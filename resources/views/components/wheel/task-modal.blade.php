        <div id="task-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60">

            <div class="relative w-full max-w-2xl p-6 bg-white rounded-lg shadow-xl">

                <div class="flex items-start justify-between pb-4 border-b border-gray-200">
                    <h2 id="modal-title" class="text-2xl font-semibold text-gray-900"></h2>
                    <button type="button" class="task-modal-close text-gray-400 transition-colors hover:text-gray-900">
                        <span class="text-2xl font-bold">&times;</span>
                    </button>
                </div>

                <div id="modal-body" class="mt-4 prose max-w-none"></div>

                <div class="flex justify-between mt-4 pt-4 border-t border-gray-200">
                    <div class="text-sm text-gray-600 space-y-1">
                        <p>
                            <strong class="font-medium text-gray-800">Creator:</strong>
                            <span id="modal-creator"></span>
                        </p>
                        <p>
                            <strong class="font-medium text-gray-800">Assignee:</strong>
                            <span id="modal-assignee"></span>
                        </p>
                    </div>
                    <div class="w-50">
                        <x-ui.primary-button type="button">Take task</x-ui.primary-button>
                    </div>
                </div>


            </div>
        </div>
