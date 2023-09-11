<script>
    if (typeof(mr4LcUpdateBirthday) == 'undefined') {
        mr4LcUpdateBirthday = function(id, onchange) {
            const year = document.getElementById(id + '__year')
            const month = document.getElementById(id + '__month')
            const day = document.getElementById(id + '__day')
            const ctrl = document.getElementById(id)
            const oldValue = ctrl.value
            if (year && year.value !== '' && month && month.value !== '' && day && day.value !== '') {
                ctrl.value = year.value.toString().padStart(4, '0') + "-" + month.value.toString().padStart(2,
                    '0') + "-" + day.value.toString().padStart(2, '0')
            } else {
                ctrl.value = ''
            }

            if (undefined !== onchange && null !== onchange && '' !== onchange) {
                const event = window.event
                window[onchange]({
                    ...event,
                    target: ctrl,
                    oldValue: oldValue,
                    type: 'change',
                    currentTarget: event.target,
                    timeStamp: event.timeStamp
                })
            }
        }
    }
    if (typeof(mr4LcSelectBirthday) == 'undefined') {
        mr4LcSelectBirthday = function(ctrl, maxValue, minValue, onchange) {
            let controlId = null
            let nextControlId = null
            let preControlId = null
            let nextControl = null
            let preControl = null
            let labelNextControl = null
            let nextType = null

            if (ctrl.id.endsWith("__year")) {
                controlId = ctrl.id.replace("__year", "")
                nextControlId = ctrl.id.replace("__year", "__month")
                preControlId = ctrl.id
                nextType = 'month'
            }
            if (ctrl.id.endsWith("__month")) {
                controlId = ctrl.id.replace("__month", "")
                nextControlId = ctrl.id.replace("__month", "__day")
                preControlId = ctrl.id.replace("__month", "__year")
                nextType = 'day'
            }
            if (ctrl.id.endsWith("__day")) {
                controlId = ctrl.id.replace("__day", "")
                preControlId = ctrl.id.replace("__day", "__month")
            }

            nextControl = document.getElementById(nextControlId)
            preControl = document.getElementById(preControlId)
            labelNextControl = document.querySelector("label[for='" + nextControlId + "']")

            if (nextControl) {
                nextControl.disabled = ctrl.value === ''
                const placeholder = labelNextControl ? labelNextControl.innerText : ''
                const oldValue = nextControl.value
                nextControl.innerHTML = ''
                switch (nextType) {
                    case 'month':
                        let maxMonth = 12
                        if (ctrl.value == maxValue.getFullYear()) {
                            maxMonth = maxValue.getMonth()
                        }
                        var option = document.createElement("option");
                        option.text = placeholder;
                        option.value = '';
                        nextControl.appendChild(option);
                        for (let index = maxMonth; index >= 1; index--) {
                            var option = document.createElement("option")
                            option.text = index;
                            option.value = index;
                            if (oldValue == index) {
                                option.selected = true
                            }
                            nextControl.appendChild(option)
                        }
                        break
                    case 'day':
                        var lastDate = new Date(preControl.value, ctrl.value, 0)
                        let maxDay = lastDate.getDate()
                        if (preControl.value == maxValue.getFullYear() && ctrl.value == maxValue.getMonth()) {
                            maxDay = maxValue.getDate()
                        }
                        var option = document.createElement("option");
                        option.text = placeholder;
                        option.value = '';
                        nextControl.appendChild(option);
                        for (let index = maxDay; index >= 1; index--) {
                            var option = document.createElement("option")
                            option.text = index;
                            option.value = index;
                            if (oldValue == index) {
                                option.selected = true
                            }
                            nextControl.appendChild(option)
                        }
                        break
                }
            }
            mr4LcUpdateBirthday(controlId, onchange)
        }
    }
</script>
<style>
    .mr4-lc-select-birthday select {
        display: inline;
    }

    .mr4-lc-select-birthday label {
        display: inline;
        font-weight: normal;
        margin-right: 4px;
    }

    .mr4-lc-select-birthday .year {
        width: 6em;
    }

    .mr4-lc-select-birthday .month {
        width: 6em;
    }

    .mr4-lc-select-birthday .day {
        width: 6em;
    }

    .mr4-lc-select-birthday-input {
        /* width: 0px;
        opacity: 0;
        margin-left: -14px; */
        cursor: default;
    }
</style>
@php
    $initYear = isset($value) ? $value->year : null;
    $initMonth = isset($value) ? $value->month : null;
    $initDay = isset($value) ? $value->day : null;
@endphp
<div class="{{ $options['class-form-group'] }}">
    <select class="{{ $options['class-form-control-year'] }}" name="{{ $name . '__year' }}" id="{{ $name . '__year' }}"
        {{ $required ? 'required' : '' }}
        onchange="mr4LcSelectBirthday(this, new Date('{{ $options['max']->year }}', '{{ $options['max']->month }}', '{{ $options['max']->day }}'), new Date('{{ $options['min']->year }}', '{{ $options['min']->month }}', '{{ $options['min']->day }}'), '{{ $onchange }}')">
        @foreach ($options['year'] as $key => $data)
            <option value="{{ $key }}" {{ $key === $initYear ? 'selected' : '' }}>{{ $data }}
            </option>
        @endforeach
    </select>
    <label class="{{ $options['class-form-label-year'] }}"
        for="{{ $name . '__year' }}">{{ $options['label']['year'] }}</label>
    <select class="{{ $options['class-form-control-month'] }}" name="{{ $name . '__month' }}"
        id="{{ $name . '__month' }}" {{ $required ? 'required' : '' }} {{ isset($initMonth) ? '' : 'disabled' }}
        onchange="mr4LcSelectBirthday(this, new Date('{{ $options['max']->year }}', '{{ $options['max']->month }}', '{{ $options['max']->day }}'), new Date('{{ $options['min']->year }}', '{{ $options['min']->month }}', '{{ $options['min']->day }}'), '{{ $onchange }}')">
        @foreach ($options['month'] as $key => $data)
            <option value="{{ $key }}" {{ $key === $initMonth ? 'selected' : '' }}>{{ $data }}
            </option>
        @endforeach
    </select>
    <label class="{{ $options['class-form-label-month'] }}"
        for="{{ $name . '__month' }}">{{ $options['label']['month'] }}</label>
    <select class="{{ $options['class-form-control-day'] }}" name="{{ $name . '__day' }}" id="{{ $name . '__day' }}"
        {{ $required ? 'required' : '' }} {{ isset($initDay) ? '' : 'disabled' }}
        onchange="mr4LcSelectBirthday(this, new Date('{{ $options['max']->year }}', '{{ $options['max']->month }}', '{{ $options['max']->day }}'), new Date('{{ $options['min']->year }}', '{{ $options['min']->month }}', '{{ $options['min']->day }}'), '{{ $onchange }}')">
        @foreach ($options['day'] as $key => $data)
            <option value="{{ $key }}" {{ $key === $initDay ? 'selected' : '' }}>{{ $data }}
            </option>
        @endforeach
    </select>
    <label class="{{ $options['class-form-label-day'] }}"
        for="{{ $name . '__day' }}">{{ $options['label']['day'] }}</label>
    <input type="text" class="mr4-lc-select-birthday-input" name="{{ $name }}" id="{{ $name }}"
        value="{{ isset($value) ? $value->format('Y-m-d') : '' }}" {{ $required ? 'required' : '' }}>
</div>
