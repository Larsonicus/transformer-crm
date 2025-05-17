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

class Create extends Component
{
    use RequestFormState;

    public $title;
    public $description;
    public $user_id;
    public $partner_id;
    public $source_id;
    public $status = 'new';

    // Флаги для прав доступа
    public $canManageUsers = false;
    public $canManagePartners = false;
    public $canManageSources = false;
    public $canChangeStatus = false;

    public function mount()
    {
        $this->initializeRequestFormState();
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

            ClientRequest::create($validatedData);

            session()->flash('success', 'Заявка успешно создана');
            return redirect()->route('requests.index');
        } catch (Exception $e) {
            Log::error('Ошибка при создании заявки: ' . $e->getMessage());
            session()->flash('error', 'Произошла ошибка при создании заявки. Пожалуйста, попробуйте еще раз.');
            return null;
        }
    }

    public function render()
    {
        try {
            $users = $this->canManageUsers ? User::all() : collect([Auth::user()]);
            $partners = $this->canManagePartners ? Partner::all() : ($this->partner_id ? Partner::where('id', $this->partner_id)->get() : collect([]));
            $sources = $this->canManageSources ? Source::all() : Source::all(); // Источники видны всем

            return view('livewire.request.create', [
                'users' => $users,
                'partners' => $partners,
                'sources' => $sources
            ]);
        } catch (Exception $e) {
            Log::error('Ошибка при загрузке данных формы: ' . $e->getMessage());
            session()->flash('error', 'Ошибка при загрузке данных. Пожалуйста, обновите страницу.');
            return view('livewire.request.create', [
                'users' => [],
                'partners' => [],
                'sources' => []
            ]);
        }
    }
}
