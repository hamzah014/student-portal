<script>

    $(document).ready(function(){

       $(document).on('click', '.btn-join', function () {

            let userid = '{{ Auth::user()->id }}';

            let id = $(this).data('id');
            let title = $(this).data('title');

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to join "+title+"?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: '<i class="fa fa-check-circle"></i> Yes, continue',
                cancelButtonText: '<i class="fa fa-circle-xmark"></i> No, cancel',
                customClass: {
                    confirmButton: 'btn btn-primary mx-2',
                    cancelButton: 'btn btn-secondary'
                },
                buttonsStyling: false,
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    
                    var data = { 
                                id: id,
                                userid: userid
                            };
                    sendRequest('request', data);
                }
            });
            
        });

       $(document).on('click', '.btn-withdraw', function () {

            let userid = '{{ Auth::user()->id }}';

            let id = $(this).data('id');
            let title = $(this).data('title');

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to withdraw "+title+"?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '<i class="fa fa-check-circle"></i> Yes, continue',
                cancelButtonText: '<i class="fa fa-circle-xmark"></i> No, cancel',
                customClass: {
                    confirmButton: 'btn btn-primary mx-2',
                    cancelButton: 'btn btn-secondary'
                },
                buttonsStyling: false,
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    
                    var data = { 
                                id: id,
                                userid: userid
                            };
                    sendRequest('withdraw', data);
                }
            });
            
        });

       $(document).on('click', '.btn-approve', function () {

            let userid = '{{ Auth::user()->id }}';
            let id = $(this).data('id');
            let title = $(this).data('title');

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to approve "+title+" for this class?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '<i class="fa fa-check-circle"></i> Yes, continue',
                cancelButtonText: '<i class="fa fa-circle-xmark"></i> No, cancel',
                customClass: {
                    confirmButton: 'btn btn-primary mx-2',
                    cancelButton: 'btn btn-secondary'
                },
                buttonsStyling: false,
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    
                    var data = { 
                                id: id,
                                userid: userid
                            };
                    sendRequest('approve', data);
                }
            });
            
        });


        function sendRequest(type, data)
        {

            if(type == 'request'){                

                var route = '{{ route('class.request') }}';
                
                var formData = new FormData();
                formData.append('type', 'request');
                formData.append('id', data['id']);
                formData.append('userid', data['userid']);

            }
            else if(type == 'withdraw'){                

                var route = '{{ route('class.request') }}';
                
                var formData = new FormData();
                formData.append('type', 'withdraw');
                formData.append('id', data['id']);
                formData.append('userid', data['userid']);

            }
            else if(type == 'approve'){                

                var route = '{{ route('lect.class.request') }}';
                
                var formData = new FormData();
                formData.append('type', 'approve');
                formData.append('id', data['id']);
                formData.append('userid', data['userid']);

            }
                    
            $.ajax({
                url: route,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    console.log(response);

                    if (response.success) {
                        window.location.reload(true);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(error) {
                    
                    console.log('error', error);

                    var response = error.responseJSON;
                    console.log(response);

                    if (response && response.error) {
                        // Laravel validation errors
                        var messages = [];

                        for (var field in response.error) {
                            if (response.error.hasOwnProperty(field)) {
                                messages.push(response.error[field].join(', '));
                            }
                        }

                        alert('Error:\n' + messages.join('\n'));
                    } 
                    else if (response && response.message) {
                        // Other error message
                        alert('Error - ' + response.message);
                    } 
                    else {
                        alert('An unknown error occurred!');
                    }
                }
            });


        }


    });


</script>