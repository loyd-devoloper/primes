<div >


            <div wire:loading wire:target='_finishUpload'>
                <div class="fixed top-0 min-h-[100svh] bg-black/60  left-0 w-full  flex justify-center items-center z-[999]" >

                    <?php echo $__env->make('components.loading', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>



    <?php echo e($this->table); ?>

</div>
<?php /**PATH /home/loyd-deped/Desktop/www/PDS/resources/views/livewire/leave/bulk_dtr.blade.php ENDPATH**/ ?>