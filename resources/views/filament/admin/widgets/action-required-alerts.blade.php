<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex items-center justify-between px-2 pb-4 mb-2 border-b border-gray-100 dark:border-white/5">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Action Required</h3>
        </div>
        
        <div class="space-y-4 px-2">
            <!-- System Update Alert -->
            <div class="flex items-start space-x-3 cursor-pointer group">
                <div class="bg-amber-100 dark:bg-amber-500/10 p-2 rounded-lg mt-0.5 group-hover:bg-amber-200 transition">
                    <x-heroicon-o-exclamation-triangle class="w-5 h-5 text-amber-600 dark:text-amber-500" />
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">System Update Available</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Version 2.4.1 includes security patches and new report templates.</p>
                    <button class="text-primary-600 dark:text-primary-400 text-xs font-medium mt-2 hover:underline">Update Now</button>
                </div>
            </div>

            <!-- Attendance Alert -->
            <div class="flex items-start space-x-3 cursor-pointer group">
                <div class="bg-rose-100 dark:bg-rose-500/10 p-2 rounded-lg mt-0.5 group-hover:bg-rose-200 transition">
                    <x-heroicon-o-exclamation-circle class="w-5 h-5 text-rose-600 dark:text-rose-500" />
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Low Attendance Alert</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Grade 10-B dropped below 85% attendance this week.</p>
                    <button class="text-primary-600 dark:text-primary-400 text-xs font-medium mt-2 hover:underline">View Details</button>
                </div>
            </div>

            <!-- Admissions Alert -->
            <div class="flex items-start space-x-3 cursor-pointer group">
                <div class="bg-blue-100 dark:bg-blue-500/10 p-2 rounded-lg mt-0.5 group-hover:bg-blue-200 transition">
                    <x-heroicon-o-users class="w-5 h-5 text-blue-600 dark:text-blue-500" />
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">12 Pending Admissions</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">New applications require principal approval.</p>
                    <button class="text-primary-600 dark:text-primary-400 text-xs font-medium mt-2 hover:underline">Review Applications</button>
                </div>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
