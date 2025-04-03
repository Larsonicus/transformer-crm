<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Заголовок</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Пользователь</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Партнёр</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Источник</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Статус</th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
            @foreach($requests as $request)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">{{ $request->title }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $request->user->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $request->partner->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $request->source->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                            {{ $request->status === 'new' ? 'bg-blue-100 text-blue-800' :
                               ($request->status === 'in_progress' ? 'bg-yellow-100 text-yellow-800' :
                               'bg-green-100 text-green-800') }}">
                            {{ $request->status }}
                        </span>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
