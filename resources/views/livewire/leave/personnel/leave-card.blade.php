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
                    {{-- CTO --}}
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

                    {{--cto--}}
                    <th style=" padding: 8px;" class="border border-black dark:border-white">EARNED</th>
                    <th style=" padding: 8px;" class="border border-black dark:border-white">Absence <br> Undertime <br>
                        W/ Pay</th>
                    <th style=" padding: 8px;" class="border border-black dark:border-white">BALANCE</th>
                    <th style=" padding: 8px;" class="border border-black dark:border-white">Absence <br> Undertime <br>
                        W/O Pay</th>
                </tr>
            </thead>
            <tbody>
                {{-- Personnel Mark --}}
                {{-- <h1 class="absolute rotate-45 font-mono text-4xl top-28 font-extrabold right-1 opacity-20 ">PERSONNEL SECTION</h1> --}}

                @foreach ($leaveData as $leave)
                    @if ($leave->start_date < \Carbon\Carbon::now())
                    <tr>
                        <td class="border border-black dark:border-white" style=" padding: 8px;text-align: center">
                            {{ $leave->period }}</td>
                        <td class="border border-black dark:border-white" style=" padding: 8px;text-align: center">
                            @if (!!$leave?->type)
                                @if($leave?->type == 'CTO' && $leave->days == null)
                                    {{ $leave->particulars }}
                                @else
                                    {{ "($leave->days-$leave->hours-$leave->mins) $leave->type" }}
                                @endif
                            @else
                                <strong>{{ $leave->particulars }}</strong>
                            @endif
                        </td>
                        {{-- VACATION LEAVE --}}
                        <td class="border border-black dark:border-white" style=" padding: 8px;text-align: center">
                            {{   $leave?->vl_earn ?? ''  }}</td>
                        <td class="border border-black dark:border-white" style=" padding: 8px;text-align: center">
                            {{ $leave->type == 'VL' || $leave->type == 'FL' || $leave->type == 'L/UT' ? $leave?->w_pay : '' }}</td>
                        <td class="border border-black dark:border-white" style=" padding: 8px;text-align: center">
                            {{ $leave?->vl_balance }}
                        </td>
                        <td class="border border-black dark:border-white" style=" padding: 8px;text-align: center">
                            {{ $leave->type == 'VL' || $leave->type == 'FL' ? $leave?->w_o_pay : '' }}</td>
                        {{-- sick leave --}}
                        <td class="border border-black dark:border-white" style=" padding: 8px;text-align: center">
                            {{ $leave?->sl_earn }}</td>
                        <td class="border border-black dark:border-white" style=" padding: 8px;text-align: center">
                            {{ $leave->type == 'SL' ? $leave?->w_pay : '' }}</td>
                        <td class="border border-black dark:border-white" style=" padding: 8px;text-align: center">
                            {{ $leave?->sl_balance }}
                        </td>
                        <td class="border border-black dark:border-white" style=" padding: 8px;text-align: center">
                            {{ $leave->type == 'SL' ? $leave?->w_o_pay : '' }}</td>

                        {{-- CTO --}}
                        <td class="border border-black dark:border-white" style=" padding: 8px;text-align: center">
                            {{ $leave->type == 'CTO' ?  $leave?->vl_earn : ''  }}
                            </td>
                        <td class="border border-black dark:border-white" style=" padding: 8px;text-align: center">
                            {{ $leave->type == 'CTO' ? $leave?->w_pay : '' }}</td>
                        <td class="border border-black dark:border-white" style=" padding: 8px;text-align: center">
                            {{ $leave?->cto_balance }}
                        </td>
                        <td class="border border-black dark:border-white" style=" padding: 8px;text-align: center">
                            {{ $leave->type == 'CTO' ? $leave?->w_o_pay : '' }}</td>
                        <td class="border border-black dark:border-white"
                            style=" padding: 0px;max-width: 4rem;text-align: center">
                            <p style="">{{ $leave?->remarks }}</p>
                        </td>
                    </tr>
                    @endif
                @endforeach

            </tbody>
        </table>
    </div>

</div>
