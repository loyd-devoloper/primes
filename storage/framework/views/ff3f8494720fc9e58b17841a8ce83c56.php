<div>



    <div style="margin: 0%;padding:0%;font-size:.6rem" class="relative">

        <table style="width: 100%; border-collapse: collapse;"
            class="border border-black dark:border-white dark:text-white">
            <thead>
                <tr>
                    <th style=" padding: 8px;" class="border border-black dark:border-white" rowspan="2">PERIOD</th>
                    <th style=" padding: 8px;" class="border border-black dark:border-white" rowspan="2">PARTICULARS
                    </th>

                    <th style=" padding: 8px;" class="border border-black dark:border-white" colspan="4">VACATION
                        LEAVE</th>
                    <th style=" padding: 8px;" class="border border-black dark:border-white" colspan="4">SICK LEAVE
                    </th>
                    
                    <th style=" padding: 8px;" class="border border-black dark:border-white" colspan="4">CTO
                    </th>
                    <th style=" padding: 8px;" class="border border-black dark:border-white" rowspan="2">REMARKS</th>
                </tr>
                <tr>
                    <th style=" padding: 8px;" class="border border-black dark:border-white">EARNED</th>
                    <th style=" padding: 8px;" class="border border-black dark:border-white">Absence <br> Undertime <br>
                        W/ Pay</th>
                    <th style=" padding: 8px;" class="border border-black dark:border-white">BALANCE</th>
                    <th style=" padding: 8px;" class="border border-black dark:border-white">Absence <br> Undertime <br>
                        W/O Pay</th>

                    <th style=" padding: 8px;" class="border border-black dark:border-white">EARNED</th>
                    <th style=" padding: 8px;" class="border border-black dark:border-white">Absence <br> Undertime <br>
                        W/ Pay</th>
                    <th style=" padding: 8px;" class="border border-black dark:border-white">BALANCE</th>
                    <th style=" padding: 8px;" class="border border-black dark:border-white">Absence <br> Undertime <br>
                        W/O Pay</th>

                    
                    <th style=" padding: 8px;" class="border border-black dark:border-white">EARNED</th>
                    <th style=" padding: 8px;" class="border border-black dark:border-white">Absence <br> Undertime <br>
                        W/ Pay</th>
                    <th style=" padding: 8px;" class="border border-black dark:border-white">BALANCE</th>
                    <th style=" padding: 8px;" class="border border-black dark:border-white">Absence <br> Undertime <br>
                        W/O Pay</th>
                </tr>
            </thead>
            <tbody>
                
                

                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $leaveData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $leave): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <!--[if BLOCK]><![endif]--><?php if($leave->start_date < \Carbon\Carbon::now()): ?>
                    <tr>
                        <td class="border border-black dark:border-white" style=" padding: 8px;text-align: center">
                            <?php echo e($leave->period); ?></td>
                        <td class="border border-black dark:border-white" style=" padding: 8px;text-align: center">
                            <!--[if BLOCK]><![endif]--><?php if(!!$leave?->type): ?>
                                <!--[if BLOCK]><![endif]--><?php if($leave?->type == 'CTO' && $leave->days == null): ?>
                                    <?php echo e($leave->particulars); ?>

                                <?php else: ?>
                                    <?php echo e("($leave->days-$leave->hours-$leave->mins) $leave->type"); ?>

                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <?php else: ?>
                                <strong><?php echo e($leave->particulars); ?></strong>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </td>
                        
                        <td class="border border-black dark:border-white" style=" padding: 8px;text-align: center">
                            <?php echo e($leave?->vl_earn ?? ''); ?></td>
                        <td class="border border-black dark:border-white" style=" padding: 8px;text-align: center">
                            <?php echo e($leave->type == 'VL' || $leave->type == 'FL' || $leave->type == 'L/UT' ? $leave?->w_pay : ''); ?></td>
                        <td class="border border-black dark:border-white" style=" padding: 8px;text-align: center">
                            <?php echo e($leave?->vl_balance); ?>

                        </td>
                        <td class="border border-black dark:border-white" style=" padding: 8px;text-align: center">
                            <?php echo e($leave->type == 'VL' || $leave->type == 'FL' ? $leave?->w_o_pay : ''); ?></td>
                        
                        <td class="border border-black dark:border-white" style=" padding: 8px;text-align: center">
                            <?php echo e($leave?->sl_earn); ?></td>
                        <td class="border border-black dark:border-white" style=" padding: 8px;text-align: center">
                            <?php echo e($leave->type == 'SL' ? $leave?->w_pay : ''); ?></td>
                        <td class="border border-black dark:border-white" style=" padding: 8px;text-align: center">
                            <?php echo e($leave?->sl_balance); ?>

                        </td>
                        <td class="border border-black dark:border-white" style=" padding: 8px;text-align: center">
                            <?php echo e($leave->type == 'SL' ? $leave?->w_o_pay : ''); ?></td>

                        
                        <td class="border border-black dark:border-white" style=" padding: 8px;text-align: center">
                            <?php echo e($leave->type == 'CTO' ?  $leave?->vl_earn : ''); ?>

                            </td>
                        <td class="border border-black dark:border-white" style=" padding: 8px;text-align: center">
                            <?php echo e($leave->type == 'CTO' ? $leave?->w_pay : ''); ?></td>
                        <td class="border border-black dark:border-white" style=" padding: 8px;text-align: center">
                            <?php echo e($leave?->cto_balance); ?>

                        </td>
                        <td class="border border-black dark:border-white" style=" padding: 8px;text-align: center">
                            <?php echo e($leave->type == 'CTO' ? $leave?->w_o_pay : ''); ?></td>
                        <td class="border border-black dark:border-white"
                            style=" padding: 0px;max-width: 4rem;text-align: center">
                            <p style=""><?php echo e($leave?->remarks); ?></p>
                        </td>
                    </tr>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

            </tbody>
        </table>
    </div>

</div>
<?php /**PATH /home/loyd-deped/Desktop/www/PDS/resources/views/livewire/leave/personnel/leave-card.blade.php ENDPATH**/ ?>