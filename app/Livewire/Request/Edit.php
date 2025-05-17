<?php
namespace App\Livewire\Request;

use Livewire\Component;
use App\Models\ClientRequest;
use App\Models\User;
use App\Models\Partner;
use App\Models\Source;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class Edit extends Component
{
    use RequestFormState;

    public ClientRequest $request;

    public function mount(ClientRequest $request)
    {
        $this->initializeRequestFormState();
        
        $this->request = $request;
        $this->title = $request->title;
        $this->description = $request->description;
        $this->user_id = $request->user_id;
        $this->partner_id = $request->partner_id;
        $this->source_id = $request->source_id;
        $this->status = $request->status;
    }

    public function rules()
    {
        return $this->getRules();
    }

    public function messages()
    {
        return $this->getValidationMessages();
    }

    public function save()
    {
        try {
            $validatedData = $this->validate();

            // Если пользователь не может управлять определенными полями,
            // используем значения по умолчанию
            if (!$this->canManageUsers) {
                $validatedData['user_id'] = Auth::id();
            }
            
            if (!$this->canManagePartners && Auth::user()->hasRole('partner')) {
                $validatedData['partner_id'] = Auth::id();
            }

            $this->request->update($validatedData);

            session()->flash('success', 'Заявка обновлена');
            return redirect()->route('requests.index');
        } catch (Exception $e) {
            Log::error('Ошибка при обновлении заявки: ' . $e->getMessage());
            session()->flash('error', 'Произошла ошибка при обновлении заявки. Пожалуйста, попробуйте еще раз.');
            return null;
        }
    }

    public function render()
    {
        try {
            $users = $this->canManageUsers ? User::all() : collect([Auth::user()]);
            $partners = $this->canManagePartners ? Partner::all() : ($this->partner_id ? Partner::where('id', $this->partner_id)->get() : collect([]));
            $sources = $this->canManageSources ? Source::all() : Source::all(); // Источники видны всем

            return view('livewire.request.edit', [
                'users' => $users,
                'partners' => $partners,
                'sources' => $sources
            ]);
        } catch (Exception $e) {
            Log::error('Ошибка при загрузке данных формы: ' . $e->getMessage());
            session()->flash('error', 'Ошибка при загрузке данных. Пожалуйста, обновите страницу.');
            return view('livewire.request.edit', [
                'users' => [],
                'partners' => [],
                'sources' => []
            ]);
        }
    }
}
