@extends('layouts.app')
@section('content')

<section class="content">

    <div class="row">
        <section class="col-lg-12">
            <div class="box box-info">

                <div class="box-header">
                    @include('booking.includes.toolbar')
                </div>

                <div class="box-body">
                    <form method="POST" action="{{ route('users.store') }}" id="createForm">
                        @csrf

                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class="row">
                                    <label for="fname">First Name</label>
                                    <input type="text" class="form-control puwy" name="fname" placeholder="Enter First Name" autofocus>
                                    <span class="invalid-feedback hidden" role="alert">
                                        <strong id="fnameError"></strong>
                                    </span>
                                </div>

                                <div class="row">
                                    <label for="lname">Last Name</label>
                                    <input type="text" class="form-control puwy" name="lname" placeholder="Enter Last Name">
                                    <span class="invalid-feedback hidden" role="alert">
                                        <strong id="lnameError"></strong>
                                    </span>
                                </div>

                                <div class="row">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control puwy" name="address" placeholder="Enter Address">
                                    <span class="invalid-feedback hidden" role="alert">
                                        <strong id="addressError"></strong>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-2 col-md-offset-10">
                                <a class="btn btn-primary submit pull-right">Register</a>
                            </div>
                        </div>

                    </form>
                </div>

                <div class="box-footer clearfix">
                </div>

            </div>
        </section>
    </div>

</section>
@endsection

@push('after-styles')
    <link rel="stylesheet" href="{{ asset('css/flatpickr.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endpush

@push('before-scripts')
    <script src="{{ asset('js/flatpickr.js') }}"></script>
    <script src="{{ asset('js/moment.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>

    <script>
        $('[name="birthday"]').flatpickr({
            altInput: true,
            altFormat: 'F j, Y',
            dateFormat: 'Y-m-d',
            maxDate: moment().format('YYYY-MM-DD')
        });

        $('[name=role]').select2({
            placeholder: 'Select Role'
        });
    </script>
@endpush

@push('after-scripts')

    <script>
        let bool;

        // VALIDATE ON SUBMIT
        $('.submit').click(() => {
            let inputs = $('.puwy:not(".input")');
            
            $.each(inputs, (index, input) => {
                let temp = $(input);
                let error = $('#' + temp.attr('name') + 'Error');
                bool = false;

                if(input.value == ""){
                    showError(input, temp, error, 'This field is required');
                }
                else if(input.type == 'email'){
                    $.ajax({
                        url: '{{ url('validate') }}',
                        data: {
                            email: input.value,
                            rules: 'email|unique:users'
                        },
                        success: result => {
                            result = JSON.parse(result);
                            if(typeof result[temp.attr('name')] != 'undefined'){
                                showError(input, temp, error, result[temp.attr('name')][0]);
                            }
                        }
                    });
                }
                else if(temp.attr('name') == 'contact'){
                    if(!/^[0-9]*$/.test(input.value)){
                        showError(input, temp, error, 'Invalid Contact Number');
                    }
                }
                else if(temp.attr('name') == 'confirm_password'){
                    if(input.value != $('[name="password"]').val()){
                        showError(input, temp, error, 'Password do not match');

                        input2 = $('[name="password"]')[0];
                        temp2 = $(input2);
                        error2 = $('#' + temp2.attr('name') + 'Error');

                        showError(input2, temp2, error2, 'Password do not match');
                    }
                    else if(input.value.length < 6){
                        showError(input, temp, error, 'Password must be at least 6 characters');

                        input2 = $('[name="password"]')[0];
                        temp2 = $(input2);
                        error2 = $('#' + temp2.attr('name') + 'Error');

                        showError(input2, temp2, error2, 'Password must be at least 6 characters');
                    }
                }

                swal('Validating');
                swal.showLoading();
                setTimeout(() => {
                    !bool? clearError(input, temp, error) : '';
                    swal.close();
                }, 1000);
            });

            // IF THERE IS NO ERROR. SUBMIT.
            setTimeout(() => {
                !$('.is-invalid').is(':visible')? $('#createForm').submit() : '';
            }, 1000)
        });

        async function showError(input, temp, error, message){
            await new Promise(resolve => setTimeout(resolve, 1000));

            bool = true;

            if(input.type != 'hidden'){
                temp.addClass('is-invalid');
            }
            else{
                temp.addClass('is-invalid');
                temp.next().addClass('is-invalid');
            }

            // DISPLAY ERROR MESSAGE
            error.text(message);
            error.parent().removeClass('hidden');
        }

        function clearError(input, temp, error){
            if($(input).hasClass('is-invalid')){
                if(input.type != 'hidden'){
                    temp.removeClass('is-invalid');
                }
                else{
                    temp.removeClass('is-invalid');
                    temp.next().removeClass('is-invalid');
                }

                // REMOVE ERROR MESSAGE IF VISIBLE
                if(error.parent().is(':visible')){
                    error.parent().addClass('hidden');
                }
            }
        }
    </script>
@endpush