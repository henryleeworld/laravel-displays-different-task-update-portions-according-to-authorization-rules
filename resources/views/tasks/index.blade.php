<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tasks') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-hidden overflow-x-auto p-6 bg-white border-b border-gray-200">
                    <div class="min-w-full align-middle">
                        <x-alert-message />

                        <x-link-button href="{{ route('tasks.create') }}">{{ __('Add New Task') }}</x-link-button>

                        <table class="min-w-full divide-y divide-gray-200 border mt-4">
                            <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                    <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Name') }}</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                    <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Description') }}</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                    <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Assigned to') }}</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                    <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Completed?') }}</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50">

                                </th>
                            </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                            @foreach($tasks as $task)
                                <tr class="bg-white">
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                        {{ $task->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                        {{ str($task->description)->limit(50) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                        @can('assign-people', $task)
                                        <a href="{{ route('tasks.edit', [$task->id, 'assignment' => 1]) }}" class="text-blue-800 underline underline-offset-4">
                                            {{ $task->user?->name ?? __('Not assigned') }}
                                        </a>
                                        @else
                                        {{ $task->user?->name ?? __('Not assigned') }}
                                        @endcan
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                        @can('change-completion-status', $task)
                                        <form action="{{ route('tasks.update', $task) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="1">
                                            <input type="hidden" name="is_completed" value="{{ (int)!$task->is_completed }}">
                                            <button type="submit" class="text-blue-800 underline underline-offset-4">
											    {{ $task->is_completed ? __('Yes') : __('No') }}
                                            </button>
                                        </form>
                                        @else
                                            {{ $task->is_completed ? __('Yes') : __('No') }}
                                        @endcan
                                    <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                        <x-link-button href="{{ route('tasks.edit', $task) }}">{{ __('Edit') }}</x-link-button>
                                        <form action="{{ route('tasks.destroy', $task) }}"
                                              class="inline-block"
                                              method="POST"
                                              onsubmit="return confirm('{{ __('Are you sure?') }}')">
                                            @csrf
                                            @method('DELETE')
                                            <x-danger-button>{{ __('Delete') }}</x-danger-button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-2">
                        {{ $tasks->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
