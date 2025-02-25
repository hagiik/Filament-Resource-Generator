<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ResourceGenerator extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-plus';
    protected static string $view = 'filament.pages.resource-generator';

    public $resourceName;
    public $fields = [];
    public $relationships = [];

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('resourceName')
                ->label('Nama Resource')
                ->required()
                ->reactive()
                ->helperText('nama resource akan dijadikan nama Model, Migration, dan Filament resource')
                ->afterStateUpdated(fn ($state, callable $set) => $set('resourceName', Str::studly($state))),
            
            Repeater::make('fields')
                ->label('Fields')
                // ->helperText('Nama resource akan dijadikan nama Model, Migration, dan Filament Resource.')
                ->hint(
                    str('[Documentation](/admin/system-documentation)') // Pastikan URL benar
                        ->inlineMarkdown()
                        ->toHtmlString()
                )
                ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Baca dokumentasi!') // Sesuaikan tooltip
                ->schema([
                    TextInput::make('name')
                        ->label('Nama Field')
                        ->required(),
                    Select::make('type')
                        ->label('Tipe Field')
                        ->required()
                        ->options([
                            'string' => 'String',
                            'text' => 'Text',
                            'longText' => 'Long Text',
                            'integer' => 'Integer',
                            'decimal' => 'Decimal',
                            'boolean' => 'Boolean',
                            'date' => 'Date',
                            'datetime' => 'DateTime',
                            'json' => 'JSON',
                            'uuid' => 'UUID',
                            'foreignId' => 'Foreign ID (Relationship)',
                        ])
                        ->reactive(),
                    Toggle::make('nullable')
                        ->label('Nullable')
                        ->default(false),
                    Toggle::make('unique')
                        ->label('Unique')
                        ->default(false),
                    TextInput::make('default')
                        ->label('Default Value')
                        ->visible(fn (callable $get) => in_array($get('type'), ['string', 'integer', 'decimal', 'boolean'])),
                ])
                ->addActionLabel('Tambah Field')
                ->defaultItems(1)
                ->cloneable(),

            Repeater::make('relationships')
                ->label('Relationships')
                ->schema([
                    Select::make('type')
                        ->label('Tipe Relasi')
                        ->required()
                        ->options([
                            'belongsTo' => 'Belongs To',
                            'hasMany' => 'Has Many',
                            'manyToMany' => 'Many To Many',
                        ]),
                    Select::make('relatedModel')
                        ->label('Related Model')
                        ->required()
                        ->options($this->getExistingModels())
                        ->searchable(),
                ])
                ->defaultItems(0),
        ];
    }

    protected function getExistingModels(): array
    {
        // Ambil semua file di direktori app/Models
        $modelFiles = File::files(app_path('Models'));

        // Ambil nama model dari file
        $models = [];
        foreach ($modelFiles as $file) {
            $models[] = Str::before($file->getFilename(), '.php');
        }

        // Format untuk opsi dropdown
        return array_combine($models, $models);
    }

    public function generateResource()
    {
        // Validasi input
        $this->validate([
            'resourceName' => 'required|string',
            'fields' => 'required|array',
            'relationships' => 'array',
        ]);

        // Generate Model
        Artisan::call('make:model', [
            'name' => $this->resourceName,
        ]);

        // Update isi model dengan $fillable, HasFactory, dan relasi
        $this->updateModelFile();

        // Generate Migration
        $migrationName = 'create_' . Str::snake(Str::plural($this->resourceName)) . '_table';
        Artisan::call('make:migration', [
            'name' => $migrationName,
            '--create' => Str::snake(Str::plural($this->resourceName)),
        ]);

        // Update isi migration berdasarkan field yang diinput
        $this->updateMigrationFile($migrationName);

        // Jalankan migrasi
        Artisan::call('migrate');

        // Generate Filament Resource
        Artisan::call('make:filament-resource', [
            'name' => $this->resourceName,
            '--generate' => true,
        ]);

        // Beri notifikasi sukses
        session()->flash('success', 'Resource berhasil dibuat!');

        // Reset form setelah proses selesai
        $this->reset(['resourceName', 'fields', 'relationships']);
    }

    protected function updateModelFile()
    {
        // Path ke file model
        $modelPath = app_path('Models/' . $this->resourceName . '.php');
    
        // Baca isi file model
        $content = file_get_contents($modelPath);
    
        // Buat definisi $fillable
        $fillableFields = collect($this->fields)->pluck('name')->map(fn ($field) => "'$field'")->implode(', ');
    
        // Buat definisi relasi
        $relationshipsCode = '';
        foreach ($this->relationships as $relationship) {
            $relatedModel = $relationship['relatedModel'];
            $relationshipType = $relationship['type'];
    
            switch ($relationshipType) {
                case 'belongsTo':
                    $relationshipsCode .= "\n    public function " . Str::camel($relatedModel) . "()\n    {\n        return \$this->belongsTo($relatedModel::class);\n    }\n";
                    break;
                case 'hasMany':
                    $relationshipsCode .= "\n    public function " . Str::camel(Str::plural($relatedModel)) . "()\n    {\n        return \$this->hasMany($relatedModel::class);\n    }\n";
                    break;
                case 'manyToMany':
                    $relationshipsCode .= "\n    public function " . Str::camel(Str::plural($relatedModel)) . "()\n    {\n        return \$this->belongsToMany($relatedModel::class);\n    }\n";
                    break;
            }
        }
    
        // Tambahkan use HasFactory di bagian atas class
        if (strpos($content, 'use Illuminate\Database\Eloquent\Factories\HasFactory;') === false) {
            $content = str_replace(
                'use Illuminate\Database\Eloquent\Model;',
                "use Illuminate\Database\Eloquent\Model;\nuse Illuminate\Database\Eloquent\Factories\HasFactory;",
                $content
            );
        }
    
        // Update isi file model
        $search = '//';
        $replace = "use HasFactory;\n\n    protected \$fillable = [$fillableFields];" . $relationshipsCode;
    
        // Ganti placeholder `//` dengan $fillable dan relasi
        if (strpos($content, $search) !== false) {
            $content = str_replace($search, $replace, $content);
        } else {
            // Jika placeholder tidak ditemukan, tambahkan ke dalam class
            $content = preg_replace(
                '/}\s*$/',
                "\n    use HasFactory;\n\n    protected \$fillable = [$fillableFields];" . $relationshipsCode . "\n}",
                $content
            );
        }
    
        // Simpan perubahan ke file model
        file_put_contents($modelPath, $content);
    
        // Debugging: Tampilkan isi file model setelah diupdate
        logger('Updated Model Content: ' . file_get_contents($modelPath));
    }

    protected function updateMigrationFile($migrationName)
    {
        // Cari file migration yang baru dibuat
        $migrationFiles = glob(database_path('migrations/*.php'));
        $latestMigrationFile = end($migrationFiles);

        // Baca isi file migration
        $content = file_get_contents($latestMigrationFile);

        // Buat definisi field berdasarkan input pengguna
        $fieldsDefinition = '';
        foreach ($this->fields as $field) {
            $fieldDefinition = "\$table->{$field['type']}('{$field['name']}')";
            if ($field['nullable']) {
                $fieldDefinition .= '->nullable()';
            }
            if ($field['unique']) {
                $fieldDefinition .= '->unique()';
            }
            if (isset($field['default'])) {
                $fieldDefinition .= '->default(' . $field['default'] . ')';
            }
            $fieldDefinition .= ";\n            ";
            $fieldsDefinition .= $fieldDefinition;
        }

        // Tambahkan foreign key untuk relasi
        foreach ($this->relationships as $relationship) {
            if ($relationship['type'] === 'belongsTo') {
                $relatedModel = $relationship['relatedModel'];
                $foreignKey = Str::snake($relatedModel) . '_id';
                $fieldsDefinition .= "\$table->foreignId('$foreignKey')->constrained()->onDelete('cascade');\n            ";
            }
        }

        // Update isi file migration
        $content = str_replace(
            '$table->id();',
            '$table->id();' . "\n            " . $fieldsDefinition,
            $content
        );

        // Simpan perubahan ke file migration
        file_put_contents($latestMigrationFile, $content);
    }
}