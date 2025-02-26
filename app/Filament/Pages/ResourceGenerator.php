<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Pages\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class ResourceGenerator extends Page
{
    use HasPageShield;
    protected function getShieldRedirectPath(): string {
        return '/'; // redirect to the root index...
    }
    protected static ?string $navigationIcon = 'heroicon-o-document-plus';
    protected static string $view = 'filament.pages.resource-generator';
    protected static ?string $navigationGroup = 'Generate';
    protected static ?string $navigationLabel = 'Resource Generator';


    public $resourceName;
    public $fields = [];
    public $relationships = [];
    protected function getActions(): array
    {
        return [
            Action::make('generatePermissions') // Tombol baru untuk generate permissions
                ->label('Generate Permissions')
                ->action(function () {
                    try {
                        // Jalankan perintah shield:generate --all
                        Artisan::call('shield:generate', [
                            '--all' => true,
                            '--panel' => 'admin', // Sesuaikan dengan panel yang Anda gunakan
                        ]);
    
                        // Ambil output dari perintah
                        $output = Artisan::output();
    
                        // Periksa apakah ada yang di-generate
                        if (str_contains($output, 'Nothing to generate')) {
                            // Beri notifikasi bahwa tidak ada yang di-generate
                            Notification::make()
                                ->title('No Permissions to Generate')
                                ->body('There are no new permissions to generate.')
                                ->info()
                                ->send();
                        } else {
                            // Beri notifikasi sukses
                            Notification::make()
                                ->title('Permissions Generated Successfully')
                                ->body('Permissions for the admin panel have been generated.')
                                ->success()
                                ->send();
                        }
                    } catch (\Exception $e) {
                        // Beri notifikasi error
                        Notification::make()
                            ->title('Failed to Generate Permissions')
                            ->body('Error: ' . $e->getMessage())
                            ->danger()
                            ->send();
                    }
                })
                ->icon('heroicon-o-cog') // Icon untuk tombol
                ->color('success') // Warna tombol
                ->requiresConfirmation(), // Konfirmasi sebelum menjalankan
        ];
    }

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
                            'bigIncrements' => 'Big Increments',
                            'bigInteger' => 'Big Integer',
                            'binary' => 'Binary',
                            'boolean' => 'Boolean',
                            'char' => 'Char',
                            'date' => 'Date',
                            'dateTime' => 'DateTime',
                            'dateTimeTz' => 'DateTime with Timezone',
                            'decimal' => 'Decimal',
                            'double' => 'Double',
                            'enum' => 'Enum',
                            'float' => 'Float',
                            'foreignId' => 'Foreign ID',
                            'geometry' => 'Geometry',
                            'geometryCollection' => 'Geometry Collection',
                            'increments' => 'Increments',
                            'integer' => 'Integer',
                            'ipAddress' => 'IP Address',
                            'json' => 'JSON',
                            'jsonb' => 'JSONB',
                            'lineString' => 'Line String',
                            'longText' => 'Long Text',
                            'macAddress' => 'MAC Address',
                            'mediumIncrements' => 'Medium Increments',
                            'mediumInteger' => 'Medium Integer',
                            'mediumText' => 'Medium Text',
                            'morphs' => 'Morphs',
                            'multiLineString' => 'Multi Line String',
                            'multiPoint' => 'Multi Point',
                            'multiPolygon' => 'Multi Polygon',
                            'nullableMorphs' => 'Nullable Morphs',
                            'nullableTimestamps' => 'Nullable Timestamps',
                            'nullableUuidMorphs' => 'Nullable UUID Morphs',
                            'point' => 'Point',
                            'polygon' => 'Polygon',
                            'rememberToken' => 'Remember Token',
                            'set' => 'Set',
                            'smallIncrements' => 'Small Increments',
                            'smallInteger' => 'Small Integer',
                            'softDeletes' => 'Soft Deletes',
                            'softDeletesTz' => 'Soft Deletes with Timezone',
                            'string' => 'String',
                            'text' => 'Text',
                            'time' => 'Time',
                            'timeTz' => 'Time with Timezone',
                            'timestamp' => 'Timestamp',
                            'timestampTz' => 'Timestamp with Timezone',
                            'timestamps' => 'Timestamps',
                            'timestampsTz' => 'Timestamps with Timezone',
                            'tinyIncrements' => 'Tiny Increments',
                            'tinyInteger' => 'Tiny Integer',
                            'unsignedBigInteger' => 'Unsigned Big Integer',
                            'unsignedDecimal' => 'Unsigned Decimal',
                            'unsignedInteger' => 'Unsigned Integer',
                            'unsignedMediumInteger' => 'Unsigned Medium Integer',
                            'unsignedSmallInteger' => 'Unsigned Small Integer',
                            'unsignedTinyInteger' => 'Unsigned Tiny Integer',
                            'uuid' => 'UUID',
                            'uuidMorphs' => 'UUID Morphs',
                            'year' => 'Year',
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
                    TextInput::make('comment')
                        ->label('Comment')
                        ->visible(fn (callable $get) => $get('type') !== 'id'),
                    Toggle::make('unsigned')
                        ->label('Unsigned')
                        ->default(false)
                        ->visible(fn (callable $get) => in_array($get('type'), ['integer', 'bigInteger', 'decimal', 'unsignedInteger', 'unsignedBigInteger', 'unsignedDecimal'])),
                    Toggle::make('autoIncrement')
                        ->label('Auto Increment')
                        ->default(false)
                        ->visible(fn (callable $get) => in_array($get('type'), ['integer', 'bigInteger', 'increments', 'bigIncrements'])), 
                    Toggle::make('index')
                        ->label('Index')
                        ->default(false),
                        Toggle::make('fulltext')
                        ->label('Fulltext Index')
                        ->default(false)
                        ->visible(fn (callable $get) => in_array($get('type'), ['text', 'longText', 'mediumText'])),
                        Toggle::make('useCurrent')
                        ->label('Use Current Timestamp')
                        ->default(false)
                        ->visible(fn (callable $get) => in_array($get('type'), ['timestamp', 'dateTime', 'timestamps'])),
                    
                    Toggle::make('useCurrentOnUpdate')
                        ->label('Use Current Timestamp on Update')
                        ->default(false)
                        ->visible(fn (callable $get) => in_array($get('type'), ['timestamp', 'dateTime', 'timestamps'])),
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
        $models = [];
    
        // Cek apakah direktori app/Models ada
        if (File::exists(app_path('Models'))) {
            // Ambil semua file di direktori app/Models
            $modelFiles = File::files(app_path('Models'));
    
            // Ambil nama model dari file
            foreach ($modelFiles as $file) {
                $models[] = Str::before($file->getFilename(), '.php');
            }
        }
    
        // Format untuk opsi dropdown
        return array_combine($models, $models);
    }

    public function generateResource()
    {
        try {
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
    
              // Generate Shield permissions dengan opsi --panel=admin
              $exitCode = Artisan::call('shield:generate', [
                '--all' => true,
                '--panel' => 'admin', // Berikan input panel secara otomatis
            ]);
    
            // Debugging: Tampilkan output perintah
            $output = Artisan::output();
            logger('Shield generate output: ' . $output);
    

            // Beri notifikasi sukses
            session()->flash('success', 'Resource berhasil dibuat dan Silahkan Klik tombol Di kanan atas untuk permissions Shield di-generate!');
        } catch (\Exception $e) {
            // Beri notifikasi error
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    
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
        if (empty($migrationFiles)) {
            return;
        }
    
        $latestMigrationFile = end($migrationFiles);
    
        // Baca isi file migration
        $content = file_get_contents($latestMigrationFile);
    
        // Buat definisi field berdasarkan input pengguna
        $fieldsDefinition = '';
        foreach ($this->fields as $field) {
            $fieldDefinition = "\$table->{$field['type']}('{$field['name']}')";
    
            // Tambahkan opsi tambahan
            if ($field['nullable']) {
                $fieldDefinition .= '->nullable()';
            }
            if ($field['unique']) {
                $fieldDefinition .= '->unique()';
            }
            if (isset($field['default'])) {
                $fieldDefinition .= '->default(' . $field['default'] . ')';
            }
            if (isset($field['comment'])) {
                $fieldDefinition .= '->comment("' . $field['comment'] . '")';
            }
            if ($field['unsigned']) {
                $fieldDefinition .= '->unsigned()';
            }
            if ($field['autoIncrement']) {
                $fieldDefinition .= '->autoIncrement()';
            }
            if ($field['index']) {
                $fieldDefinition .= '->index()';
            }
            if ($field['fulltext']) {
                $fieldDefinition .= '->fulltext()';
            }
            if ($field['useCurrent']) {
                $fieldDefinition .= '->useCurrent()';
            }
            if ($field['useCurrentOnUpdate']) {
                $fieldDefinition .= '->useCurrentOnUpdate()';
            }
    
            $fieldDefinition .= ";\n            ";
            $fieldsDefinition .= $fieldDefinition;
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