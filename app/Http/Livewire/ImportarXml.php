<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class ImportarXml extends Component
{
    use WithFileUploads;

    public $xml;

    public function updatedXml()
    {
        $this->validate([
            'xml' => 'required|mimes:xml',
        ]);

        // Lógica para processar o XML
        $xmlContent = simplexml_load_file($this->xml->getRealPath());

        // Exemplo: dd($xmlContent);
    }

    public function render()
    {
        return view('livewire.importar-xml');
    }
}
