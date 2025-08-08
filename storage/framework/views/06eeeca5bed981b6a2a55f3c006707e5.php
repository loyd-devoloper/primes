<div>
    <!--[if BLOCK]><![endif]--><?php if(\Carbon\Carbon::parse('01-12-2024')->format('F') == \Carbon\Carbon::now()->format('F')): ?>
        <ul class="lightrope z-50">
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>

        </ul>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    
    <div class="flex  min-h-[100svh] max-h-[100svh] overflow-hidden   relative  dark:bg-bgDark  z-20"
        x-data="skillDisplay">


        <div wire:offline id="sticky-banner" tabindex="-1" class="fixed top-0 start-0 z-50 flex justify-between w-full p-4 border-b border-gray-200 bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
            <div class="flex items-center mx-auto">
                <p class="flex items-center text-sm font-normal text-gray-500 dark:text-gray-400">
            <span class="inline-flex p-1 me-3 bg-gray-200 rounded-full dark:bg-gray-600 w-6 h-6 items-center justify-center shrink-0">
                <svg class="w-3 h-3 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 19">
                    <path d="M15 1.943v12.114a1 1 0 0 1-1.581.814L8 11V5l5.419-3.871A1 1 0 0 1 15 1.943ZM7 4H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2v5a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2V4ZM4 17v-5h1v5H4ZM16 5.183v5.634a2.984 2.984 0 0 0 0-5.634Z"/>
                </svg>
                <span class="sr-only">Light bulb</span>
            </span>
                    <span>No Internet Connection</span>
                </p>
            </div>

        </div>



        <?php echo e($modal); ?>

        <div wire:loading wire:target='<?php echo e($target); ?>' class="z-50">
            <div class="fixed top-0 h-[100dvh] bg-black/60  left-0 w-full  flex justify-center items-center">
                
                <?php echo $__env->make('components.loading', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
        
        <span x-cloak :class="aside ? 'hidden xl:block' : 'block xl:block'" class="relative z-30 " x-transition>
            <?php echo $__env->make('components.assets.admin_aside', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </span>
        
        
        <section class="w-full min-h-[100svh] max-h-[100svh] overflow-hidden  ">
            <div
                class="bg-gradient-to-r from-[#0061ff] to-[#60efff] dark:bg-gradient-to-r dark:from-blue-800 dark:to-indigo-900 fixed -z-10 top-0 left-0  w-full min-h-[35svh]">
            </div>

            
            <?php echo $__env->make('components.assets.topNav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class=" overflow-y-auto min-h-[calc(100svh-6rem)] max-h-[calc(100svh-6rem)] ml-0 z-0 mt-[6rem] pb-10 px-2 sm:px-5 xl:px-10"
                :class='aside ? "w-full xl:max-w-[calc(100svw-270px)]" : "w-full xl:max-w-[calc(100svw-270px)]"'>

                <?php echo e($slot); ?>

            </div>


        </section>
        
    </div>
</div>
<?php /**PATH /home/loyd-deped/Desktop/www/PDS/resources/views/components/assets/admin_layout.blade.php ENDPATH**/ ?>