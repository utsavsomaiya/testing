<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\MultiSelect;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;

class Form extends Component implements HasForms
{

    use InteractsWithForms;

    public Product $product;

    public $name;

    public function mount(): void
    {
        $this->form->fill([
            'name' => $this->product->name
        ]);
    }

    protected function getFormSchema(): array
    {
        return [
            MultiSelect::make('name')
                ->relationship('tags', 'name')
                ->createOptionForm([
                    TextInput::make('name')
                        ->required()
                        ->rules(['string', 'max:255']),
                ])
                ->createOptionAction(static fn (Action $action): Action => $action
                    ->modalHeading('Create tag')
                    ->modalButton('Create tag')
                    ->modalWidth('md')
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['seller_id'] = auth()->id();

                        return $data;
                    }))
                ->required(),
        ];
    }

    protected function getFormModel(): Product
    {
        return $this->product;
    }

    public function render()
    {
        return view('livewire.form');
    }
}
