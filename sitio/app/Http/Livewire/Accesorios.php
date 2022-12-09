<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Accesorio;

class Accesorios extends Component
{
    use WithPagination;

	protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $nombre, $usuario;
    public $updateMode = false;

    public function render()
    {
		$keyWord = '%'.$this->keyWord .'%';
        return view('livewire.accesorios.view', [
            'accesorios' => Accesorio::latest()
						->orWhere('nombre', 'LIKE', $keyWord)
						->orWhere('usuario', 'LIKE', $keyWord)
						->paginate(10),
        ]);
    }
	
    public function cancel()
    {
        $this->resetInput();
        $this->updateMode = false;
    }
	
    private function resetInput()
    {		
		$this->nombre = null;
		$this->usuario = null;
    }

    public function store()
    {
        $this->validate([
		'nombre' => 'required',
		'usuario' => 'required',
        ]);

        Accesorio::create([ 
			'nombre' => $this-> nombre,
			'usuario' => $this-> usuario
        ]);
        
        $this->resetInput();
		$this->emit('closeModal');
		session()->flash('message', 'Accesorio Successfully created.');
    }

    public function edit($id)
    {
        $record = Accesorio::findOrFail($id);

        $this->selected_id = $id; 
		$this->nombre = $record-> nombre;
		$this->usuario = $record-> usuario;
		
        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate([
		'nombre' => 'required',
		'usuario' => 'required',
        ]);

        if ($this->selected_id) {
			$record = Accesorio::find($this->selected_id);
            $record->update([ 
			'nombre' => $this-> nombre,
			'usuario' => $this-> usuario
            ]);

            $this->resetInput();
            $this->updateMode = false;
			session()->flash('message', 'Accesorio Successfully updated.');
        }
    }

    public function destroy($id)
    {
        if ($id) {
            $record = Accesorio::where('id', $id);
            $record->delete();
        }
    }
}
