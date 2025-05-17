<!-- Status -->
<div>
    <x-input-label for="status" :value="__('Статус')" />
    <select id="status" name="status" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm">
        @foreach($statuses as $value => $label)
            <option value="{{ $value }}" {{ old('status', $task->status) == $value ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('status')" class="mt-2" />
</div> 