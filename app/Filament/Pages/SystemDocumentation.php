<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class SystemDocumentation extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $title = 'Dokumentasi Resources Generator';
    protected static string $view = 'filament.pages.system-documentation';
    protected static bool $shouldRegisterNavigation = false;

}
