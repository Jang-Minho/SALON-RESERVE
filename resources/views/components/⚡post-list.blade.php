<?php

use App\Models\Post;
use Livewire\Component;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

new class extends Component implements HasTable, HasSchemas, HasActions {
    use InteractsWithTable;
    use InteractsWithSchemas;
    use InteractsWithActions;

    public function table(Table $table): Table
    {
        return $table
        ->query(Post::query())
        ->columns([
        TextColumn::make('title')
        ->label('タイトル'), 
        TextColumn::make('body')
        ->label('本文')
        ->formatStateUsing(fn($state) => strip_tags($state))
        ->limit(50), 
        TextColumn::make('created_at')
        ->label('作成日時')]);
    }
};
?>

<div>
    {{ $this->table }}
</div>
