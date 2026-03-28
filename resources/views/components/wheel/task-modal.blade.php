                <div id="modal-body" class="mt-4 prose max-w-none">

                    {{ $taskText }}

                </div>

                <div class="flex justify-between mt-4 pt-4 border-t border-gray-200">
                    <div class="text-sm text-gray-600 space-y-1">
                        <p>
                            <strong class="font-medium text-gray-800">Opprettet av:</strong>
                            <span id="modal-creator">{{ $creator }}</span>
                        </p>
                        <p>
                            <strong class="font-medium text-gray-800">Tildelt til:</strong>
                            <span id="modal-assignee">{{ $assignee ?? 'Ingen' }}</span>
                        </p>
                    </div>
                    <div class="w-50">
                        <x-ui.primary-button type="button">Ta oppgaven</x-ui.primary-button>
                    </div>
                </div>
