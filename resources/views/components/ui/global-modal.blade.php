<div id="global-modal"
     class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm transition-opacity opacity-0"
     aria-hidden="true">

    <div class="bg-white w-full max-w-2xl rounded-lg shadow-2xl transform transition-all scale-95 duration-200"
         role="dialog"
         aria-modal="true">

        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h3 id="global-modal-title" class="text-xl font-bold text-gray-800">
                </h3>
            <button type="button" onclick="AppModal.close()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <div id="global-modal-body" class="p-6 overflow-y-auto max-h-[70vh] prose max-w-none">
            </div>

        <div id="global-modal-footer" class="hidden px-6 py-4 bg-gray-50 rounded-b-lg flex justify-end gap-3 border-t border-gray-100">
            </div>

    </div>
</div>
