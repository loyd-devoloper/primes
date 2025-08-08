<div x-data="skillDisplay(@entangle('attributesData'))">
    <div class="grid grid-cols-1 gap-4  overflow-y-auto max-h-[80svh] px-2 sm:px-5 xl:px-10"
        :class='aside ? " xl:max-w-[calc(100svw-270px)]" : "max-w-[calc(100svw)]"'>






        <div class="col-span-1">


        </div>
        <div class="col-span-3">
            <x-filament::section>
                <x-slot name="heading">
                    <div class="flex justify-between">
                        EDIT TEMPLATE
                        <button x-on:click='generateMe'
                            class="flex items-center gap-2 shadow-inner bg-red-600 white text-white py-2 px-5 rounded-md text-xs">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                            </svg>

                            Download Sample</button>
                    </div>
                </x-slot>

                {{-- EDITOR CONTAINER --}}
                <div class="">

                    <x-filament::section>
                        <div class="grid grid-cols-3 gap-2">
                            <div>
                                <label for="">Select FontSize</label>
                                <x-filament::input.wrapper>

                                    <x-filament::input.select x-model='textSize'>
                                        <option value="">Choose..</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="13">13</option>
                                        <option value="14">14</option>
                                        <option value="15">15</option>
                                        <option value="16">16</option>
                                        <option value="17">17</option>
                                        <option value="18">18</option>
                                        <option value="19">19</option>
                                        <option value="20">20</option>
                                        <option value="21">21</option>
                                        <option value="22">22</option>
                                        <option value="23">23</option>
                                        <option value="24">24</option>
                                        <option value="25">25</option>
                                        <option value="26">26</option>
                                        <option value="27">27</option>
                                        <option value="28">28</option>
                                        <option value="29">29</option>
                                        <option value="30">30</option>
                                        <option value="31">31</option>
                                        <option value="32">32</option>
                                        <option value="33">33</option>
                                        <option value="34">34</option>
                                        <option value="35">35</option>
                                        <option value="36">36</option>
                                        <option value="37">37</option>
                                        <option value="38">38</option>
                                        <option value="39">39</option>
                                        <option value="40">40</option>
                                        <option value="41">41</option>
                                        <option value="42">42</option>
                                        <option value="43">43</option>
                                        <option value="44">44</option>
                                        <option value="45">45</option>
                                        <option value="46">46</option>
                                        <option value="47">47</option>
                                        <option value="48">48</option>
                                        <option value="49">49</option>
                                        <option value="50">50</option>
                                        <option value="51">51</option>
                                        <option value="52">52</option>
                                        <option value="53">53</option>
                                        <option value="54">54</option>
                                        <option value="55">55</option>
                                        <option value="56">56</option>
                                        <option value="57">57</option>
                                        <option value="58">58</option>
                                        <option value="59">59</option>
                                        <option value="60">60</option>
                                        <option value="61">61</option>
                                        <option value="62">62</option>
                                        <option value="63">63</option>
                                        <option value="64">64</option>

                                    </x-filament::input.select>
                                </x-filament::input.wrapper>
                            </div>
                            <div>
                                <label for="">Select Color</label>
                                <x-filament::input.wrapper>

                                    <x-filament::input.select x-model='textColor'>
                                        <option value="black">Black</option>
                                        <option value="white">White</option>
                                        <option value="">Choose..</option>
                                        <option value="">Choose..</option>
                                        <option value="">Choose..</option>
                                        <option value="">Choose..</option>
                                        <option value="">Choose..</option>

                                    </x-filament::input.select>
                                </x-filament::input.wrapper>
                            </div>
                            <div class="flex items-end">


                                <label for="checkbox" class="py-2 px-4 rounded  "
                                    :class='textWeight ? "bg-blue-500" : "bg-transparent border border-blue-500"'>
                                    B
                                </label>


                                <input type="checkbox" class="hidden" x-model='textWeight' id="checkbox">
                            </div>
                        </div>
                    </x-filament::section>

                </div>
        </div>
    </div>
    {{-- id container --}}
    <div id="my-node" class="w-[319.5px] h-[1015px] mx-auto bg-gray-100 relative" style="">

        <div class="relative   bg-green-500 ">
            @if (!!$activeTemplate)
                @if (!!$activeTemplateData->front)
                    <img id="imageFront"
                        class="inline-block  w-[319.5px] h-[507.5333333333333px]"src="{{ asset('storage/' . $activeTemplateData->front) }}"
                        alt="">
                    <p class="absolute z-[99] hidden text-center break-words" id='firstname_f'>JOHNLOYD</p>
                    <p class="absolute   z-[99] hidden text-center break-words" id='lastname_f'>COLON</p>
                    <p class="absolute   z-[99] hidden text-center  break-words" id='middlename_f'>P.</p>
                    <p class="absolute   z-[99] hidden text-left  break-words" id='region_f'>Region IV-A
                        CALABARZON</p>
                    <p class="absolute   z-[99] hidden text-center  break-words" id='employee_id_f'>EMPLOYEE
                        NO. 1013132</p>
                    <p class=" absolute   z-[99]  text-center h-fit w-fit  break-words hidden " id='office_name_f'>
                        Administrative Officer II (HRMO I)</p>
                    <p class=" absolute   z-[99]  text-center h-fit w-fit  break-words hidden " id='position_f'>
                        Administrative Service Division</p>
                    <img class="absolute  w-[10rem] hidden " id='profile_f' src="{{ asset('assets/melvin.png') }}"
                        alt="">
                @endif
            @endif
        </div>
        {{-- <div class="relative   bg-green-500 ">
            @if (!!$activeTemplate)
                @if (!!$activeTemplateData->back)
                    <img src="{{ asset('storage/' . $activeTemplateData->back) }}" alt="">
                    <span class="absolute    z-[99] hidden  break-words" id='fullname_b'>JOHNLOYD P.
                        COLON</span>

                    <span class="absolute   z-[99] text-center hidden  break-words" id='emergency_b'>Rhian
                        colon 09101421073</span>
                    <img src="{{ asset('assets/qr-code.png') }}" id="qr_code_b" class="absolute hidden w-[10rem]"
                        alt="">
                    <img src="{{ asset('assets/SG1.png') }}" id="e_sig_b" class="absolute hidden w-[10rem] "
                        alt="" title="employee e_sig">
                    <img src="{{ asset($director ? 'storage/' . $director->e_sig : 'assets/director-e_sig.png') }}"
                        id="director_esig_b" class="absolute hidden w-[10rem]" alt="director e_sig"
                        title="director e_sig">

                    <span class="absolute   z-[99] text-center hidden  break-words"
                        id='director_name_b'>{{ $director
                            ? $director->name
                            : 'Atty.
                                                                                                                                Alberto T. Escobarte, CESO II' }}</span>
                    <span class="absolute   z-[99] text-center hidden  break-words"
                        id='director_position_b'>{{ $director ? $director->position : 'Regional Director ' }}</span>
                @endif
            @endif

        </div> --}}

    </div>
    <button x-on:click='saveTemplate'
        class="bg-emerald-500 text-white rounded-md hover:opacity-70 px-5 py-2 my-2 float-right">Updated</button>


    </x-filament::section>

</div>
@script
    <script>
        Alpine.data('skillDisplay', (datas) => ({
            aside: true,
            template_attribute_data: datas,
            newAttributeData: [],
            textSize: '20',
            textColor: 'black',
            textWeight: false,
            getDragAngle(event) {
                var element = event.target;
                var startAngle = parseFloat(element.dataset.angle) || 0;
                var center = {
                    x: parseFloat(element.dataset.centerX) || 0,
                    y: parseFloat(element.dataset.centerY) || 0,
                };
                var angle = Math.atan2(center.y - event.clientY,
                    center.x - event.clientX);

                return angle - startAngle;
            },
            htmlTag(tagId, v, vfontSize, vfontWeight, vPosition, vfontColor, vWidth, vHeight, resizableBool =
                false, rotate = false) {

                const globalThis = this;

                var fname = document.querySelector('#' + tagId);
                if (!!fname) {

                    fname.classList.remove('hidden')
                    var v = interact('#' + tagId);
                    var img = document.getElementById('imageFront');
                    // img.style.width = (img.naturalWidth / 2) + 'px';
                    var xstorage = localStorage.getItem(tagId + 'x');
                    var ystorage = localStorage.getItem(tagId + 'y');

                    v.draggable({
                        listeners: {
                            start(event) {
                                event.target.classList.add('ring-1');
                                event.target.classList.add('ring-black');
                            },
                            move(event) {
                                var target = event.target,

                                    // keep the dragged position in the data-x/data-y attributes
                                    x = (parseInt(target.getAttribute('data-x')) || 0) + event.dx,
                                    y = (parseInt(target.getAttribute('data-y')) || 0) + event.dy;



                                // target.style.transform =
                                //     'translate(' + x + 'px, ' + y + 'px)';
                                if (rotate) {
                                    target.style.transform = 'translate(' + vPosition.x + 'px, ' +
                                        vPosition.y + 'px) rotate(-90deg)';
                                } else {
                                    target.style.transform = 'translate(' + vPosition.x + 'px, ' +
                                        vPosition.y + 'px)';
                                }
                                globalThis.newAttributeData[tagId].position.x = x;
                                globalThis.newAttributeData[tagId].position.y = y;

                                // update the posiion attributes
                                target.setAttribute('data-x', x);
                                target.setAttribute('data-y', y);

                            },
                            end(event) {
                                event.target.classList.remove('ring-1');
                                event.target.classList.remove('ring-black');
                            },
                        },
                        restrict: {
                            restriction: 'parent',
                            elementRect: {
                                top: 0,
                                left: 0,
                                bottom: 0,
                                right: 1
                            },
                            inertia: true
                        },
                    })
                    v.on('doubletap', function(event) {
                        var allData = globalThis.template_attribute_data;
                        const newAttr = JSON.parse(allData.attributes.attribute);


                        event.target.style.fontSize = globalThis.textSize + 'px';
                        globalThis.newAttributeData[tagId].font_size = globalThis.textSize;
                        event.target.style.color = globalThis.textColor;
                        globalThis.newAttributeData[tagId].text_color = globalThis.textColor;
                        if (globalThis.textWeight) {
                            event.target.style.fontWeight = 'bold';
                            globalThis.newAttributeData[tagId].font_bold = 'bold';
                        } else {
                            event.target.style.fontWeight = 'normal';
                            globalThis.newAttributeData[tagId].font_bold = 'normal';
                        }

                    })

                    if (resizableBool) {
                        v.resizable({
                            edges: {
                                top: true,
                                left: false,
                                bottom: false,
                                right: true
                            },
                            listeners: {
                                start(event) {
                                    event.target.classList.add('ring-1');
                                    event.target.classList.add('ring-black');
                                },
                                move(event) {
                                    var allData = globalThis.template_attribute_data;
                                    const newAttr = JSON.parse(allData.attributes.attribute);

                                    let {
                                        x,
                                        y
                                    } = event.target.dataset


                                    x = (parseFloat(x) || 0) + event.deltaRect.left
                                    y = (parseFloat(y) || 0) + event.deltaRect.top

                                    // position.address.w = event.rect.width;
                                    // position.address.h = event.rect.height;
                                    if (rotate) {
                                        Object.assign(event.target.style, {
                                            width: `${event.rect.height}px`,
                                            height: `${event.rect.width}px`,
                                        })
                                        globalThis.newAttributeData[tagId].width = event.rect.height;
                                        globalThis.newAttributeData[tagId].height = event.rect.width;

                                    } else {
                                        Object.assign(event.target.style, {
                                            width: `${event.rect.width}px`,
                                            height: `${event.rect.height}px`,
                                            // transform: `translate(${x}px, ${y}px)`
                                        })
                                        globalThis.newAttributeData[tagId].width = event.rect.width;
                                        globalThis.newAttributeData[tagId].height = event.rect.height;
                                    }


                                    Object.assign(event.target.dataset, {
                                        x,
                                        y
                                    })

                                    // newAttr[tagId].width = ;
                                    // newAttr[tagId].height = event.rect.height;

                                },
                                end(event) {
                                    event.target.classList.remove('ring-1');
                                    event.target.classList.remove('ring-black');
                                },
                            },
                        })
                    }


                    fname.style.fontSize = `${vfontSize}px`;
                    fname.style.fontWeight = `${vfontWeight}`;
                    // fname.style.color = `black`
                    fname.style.color = `${vfontColor}`
                    if (!!vWidth) fname.style.width = `${vWidth}px`;
                    if (!!vHeight) fname.style.height = `${vHeight}px`;

                    fname.setAttribute('data-x', vPosition.x);
                    fname.setAttribute('data-y', vPosition.y);

                    if (rotate) {
                        fname.style.transform = 'translate(' + vPosition.x + 'px, ' + vPosition.y +
                            'px) rotate(-90deg)';
                    } else {
                        fname.style.transform = 'translate(' + vPosition.x + 'px, ' + vPosition.y + 'px)';
                    }

                }

            },
            saveTemplate() {

                console.log(this.newAttributeData)
                $wire.save(this.newAttributeData);
            },
            generateMe() {
                window.jsPDF = window.jspdf.jsPDF;

                var node = document.getElementById('my-node');
                var img = document.getElementById('imageFront');
                html2pdf(document.getElementById('my-node'), {
                    margin: 0,
                    filename: 'EXAMPLE TEMPLATE.pdf',
                    image: {
                        type: 'png',
                        quality: 1
                    },
                    html2canvas: {
                        scale: 5
                    },
                    // jsPDF:        { unit: 'px', format: [639,1015], orientation: 'portrait' }
                    jsPDF: {
                        unit: 'px',
                        format: [319.5, 507.5],
                        orientation: 'portrait'
                    }
                });

                // var divWidth = document.getElementById('imageFront').offsetWidth;
                // var divHeight = document.getElementById('imageFront').offsetHeight;
                // console.log(divWidth)
                // html2canvas(node, {
                //     // width: node.offsetWidth,
                //     // height: node.offsetHeight,
                //     scale:2

                // }).then(canvas => {
                //     const imgData = canvas.toDataURL('image/png');
                //     var pdf = new jsPDF();
                //     pdf.addImage(imgData, 'PNG', 0, 0);
                //     pdf.save("div-to-pdf.pdf");
                //     // const downloadLink = document.createElement('a');
                //     // downloadLink.href = imgData;
                //     // downloadLink.download = 'div-image.png';

                //     // document.body.appendChild(downloadLink);
                //     // downloadLink.click();
                //     // document.body.removeChild(downloadLink);
                // });

            },
            async init() {

                var x =@js($attributesData);
                console.log(x)
                const newAttr = JSON.parse(x.attributes.attribute);
                const newThis = this;
                this.newAttributeData = newAttr;

                Object.keys(newAttr).forEach(function(element) {
                    if (element == 'e_sig') {
                        newThis.htmlTag(element, element + 'V', newAttr[element].font_size, newAttr[
                                element].font_bold, newAttr[
                                element].position, newAttr[element].text_color, newAttr[element]
                            .width, newAttr[element].height, true);
                    } else {
                        if (element == 'office_name_f') {
                            newThis.htmlTag(element, element + 'V', newAttr[element].font_size,
                                newAttr[
                                    element].font_bold, newAttr[
                                    element].position, newAttr[element].text_color, newAttr[
                                    element]
                                .width, newAttr[element].height, true, true);
                        } else {
                            newThis.htmlTag(element, element + 'V', newAttr[element].font_size,
                                newAttr[
                                    element].font_bold, newAttr[
                                    element].position, newAttr[element].text_color, newAttr[
                                    element]
                                .width, newAttr[element].height, true);
                        }

                    }

                });



            }

        }));
    </script>
@endscript
