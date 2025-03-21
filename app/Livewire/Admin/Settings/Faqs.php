<?php

namespace App\Livewire\Admin\Settings;

use App\Models\Faq;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Faqs extends Component
{
    use WithPagination, LivewireAlert;

    public $search = '';
    public $perPage = 10;

    public $showAddForm = false;
    public $showEditForm = false;

    public $faqId;
    public $question;
    public $answer;

    protected $rules = [
        'question' => 'required|string|min:5',
        'answer' => 'required|string|min:5',
    ];

    protected $validationAttributes = [
        'question' => 'Question',
        'answer' => 'Answer',
    ];

    public function render()
    {
        $faqs = Faq::query()
            ->when($this->search, fn($query) =>
            $query->where('questions', 'like', '%' . $this->search . '%')
                ->orWhere('answers', 'like', '%' . $this->search . '%'))
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.admin.settings.faqs', [
            'faqs' => $faqs
        ]);
    }

    public function resetForm()
    {
        $this->faqId = null;
        $this->question = '';
        $this->answer = '';
        $this->resetValidation();
    }

    public function create()
    {
        $this->resetForm();
        $this->showAddForm = true;
        $this->showEditForm = false;
    }

    public function store()
    {
        $this->validate();

        Faq::create([
            'questions' => $this->question,
            'answers' => $this->answer,
        ]);

        session()->flash('success', 'FAQ added successfully.');
        $this->resetForm();
        $this->showAddForm = false;
    }

    public function edit($id)
    {
        $faq = Faq::findOrFail($id);
        $this->faqId = $faq->id;
        $this->question = $faq->questions;
        $this->answer = $faq->answers;

        $this->showEditForm = true;
        $this->showAddForm = false;
    }

    public function update()
    {
        $this->validate();

        $faq = Faq::findOrFail($this->faqId);
        $faq->update([
            'questions' => $this->question,
            'answers' => $this->answer,
        ]);

        session()->flash('success', 'FAQ updated successfully.');
        $this->resetForm();
        $this->showEditForm = false;
    }

    public function cancel()
    {
        $this->resetForm();
        $this->showAddForm = false;
        $this->showEditForm = false;
    }

    public function placeholder()
    {
        return <<<'HTML'
        <div>
        <svg width="100%" height="100%" viewBox="0 0 500 200" preserveAspectRatio="none">
            <defs>
                <linearGradient id="table-skeleton-gradient">
                    <stop offset="0%" stop-color="#f0f0f0">
                        <animate attributeName="offset" values="-2; 1" dur="1.5s" repeatCount="indefinite" />
                    </stop>
                    <stop offset="50%" stop-color="#e0e0e0">
                        <animate attributeName="offset" values="-1.5; 1.5" dur="1.5s" repeatCount="indefinite" />
                    </stop>
                    <stop offset="100%" stop-color="#f0f0f0">
                        <animate attributeName="offset" values="-1; 2" dur="1.5s" repeatCount="indefinite" />
                    </stop>
                </linearGradient>
            </defs>

            <!-- Table Header -->
            <rect x="10" y="10" rx="4" ry="4" width="80" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="100" y="10" rx="4" ry="4" width="150" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="260" y="10" rx="4" ry="4" width="100" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="370" y="10" rx="4" ry="4" width="100" height="20" fill="url(#table-skeleton-gradient)" />

            <!-- Row 1 -->
            <rect x="10" y="40" rx="4" ry="4" width="80" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="100" y="40" rx="4" ry="4" width="150" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="260" y="40" rx="4" ry="4" width="100" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="370" y="40" rx="4" ry="4" width="100" height="20" fill="url(#table-skeleton-gradient)" />

            <!-- Row 2 -->
            <rect x="10" y="70" rx="4" ry="4" width="80" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="100" y="70" rx="4" ry="4" width="150" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="260" y="70" rx="4" ry="4" width="100" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="370" y="70" rx="4" ry="4" width="100" height="20" fill="url(#table-skeleton-gradient)" />

            <!-- Row 3 -->
            <rect x="10" y="100" rx="4" ry="4" width="80" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="100" y="100" rx="4" ry="4" width="150" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="260" y="100" rx="4" ry="4" width="100" height="20" fill="url(#table-skeleton-gradient)" />
            <rect x="370" y="100" rx="4" ry="4" width="100" height="20" fill="url(#table-skeleton-gradient)" />
        </svg>

        </div>
        HTML;
    }
}
