<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;

use Filament\Schemas\Schema;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {

        return $schema
            ->components([
                TextInput::make('title')
                    ->label('タイトル')
                    ->required()
                    ->maxLength(255),

                RichEditor::make('body')
                    ->label('本文')
                    ->required()
            ]);
    }
}
