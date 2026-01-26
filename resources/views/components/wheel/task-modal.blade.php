                <div id="modal-body" class="mt-4 prose max-w-none">

                    {{ $taskText }}

                </div>

                <div class="flex justify-between mt-4 pt-4 border-t border-gray-200">
                    <div class="text-sm text-gray-600 space-y-1">
                        <p>
                            <strong class="font-medium text-gray-800">Creator:</strong>
                            <span id="modal-creator">{{ $creator }}</span>
                        </p>
                        <p>
                            <strong class="font-medium text-gray-800">Assignee:</strong>
                            <span id="modal-assignee">{{ $assignee ?? 'None' }}</span>
                        </p>
                    </div>
                    <div class="w-50">
                        <x-ui.primary-button type="button">Take task</x-ui.primary-button>
                    </div>
                </div>
