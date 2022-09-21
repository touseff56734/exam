<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>

    <div class="container">
        <h2>Modal Example</h2>

        <!-- Trigger the modal with a button -->
        <button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>
        <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#export">Export QnA</button>
        <a href="{{ url('/all-std') }}" class="btn btn-primary btn-lg" style="float: right;">All Std</a>
  <br><br>

        <table class="table table-bordered">
            <thead>
                <th>#</th>
                <th>Question</th>
                <th>Answers</th>
            </thead>
            <tbody>
                @if(count($questions)>0)
                @foreach($questions as $q)
                <tr>
                    <td>{{ $q->id }}</td>
                    <td>{{ $q->question }}</td>
                    <td>
                        <a href="#" class="answerBtn" data-toggle="modal" data-id="{{ $q->id }}" data-target="#ansBtn">Check Anwer</a>
                    </td>
                </tr>
                @endforeach
                @else

                <td colspan="3">No Question & Answers Found!</td>

                @endif

            </tbody>
        </table>

        <!-- Modal for export QnA -->
        <div class="modal fade" id="export" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                <form action="" id="Import" enctype="multipart/form-data">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Show Answers</h4>
                    </div>
                    
                    <div class="modal-body">
                       <div>
                        <input type="file" name="file" id="fileupload" required accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                       </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Import</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal for view answer -->
        <div class="modal fade" id="ansBtn" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Show Answers</h4>
                    </div>
                    <div class="modal-body">
                        <table class="table">
                            <thead>
                                <th>#</th>
                                <th>Answer</th>
                                <th>Correct</th>
                            </thead>
                            <tbody class="showAnswers">

                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <form action="" id="qna">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <span>
                                <h4 class="modal-title">Modal Header</h4>
                                <button id="add_field_button" class="ml-2">add answer</button>
                            </span>
                        </div>
                        <div class="modal-body input_fields_wrap ">
                            <input type="text" id="question" name="question" placeholder="enter Question" required><br>
                            <span class="text-danger" id="question_help"></span>
                            <span class="error" id="question_help"></span>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Submit</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- <div class="input_fields_wrap">
    <button class="add_field_button">Add More Fields</button>
    <div><input type="text" name="mytext[]"></div>
	
     </div> -->
</body>

</html>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function() {



        var max_fields = 3; //maximum input boxes allowed
        var wrapper = $(".input_fields_wrap"); //Fields wrapper
        var add_button = $("#add_field_button"); //Add button ID

        var x = 1; //initlal text box count


        $(add_button).click(function(e) { //on add input button click
            e.preventDefault();
            if (x < max_fields) { //max input box allowed

                //text box increment
                $(wrapper).append(`<div class="row input_fields_wrap"> <input type='radio' name='is_correct' id='is_correct' class='is_correct'>
                           <span> <input type="text" id="answers" name="answers[]" placeholder="enter Answer"> </span>
                            <a class='btn btn-danger remove_field'>Remove Answer</a>
                            </div>`); //add input box
                x++;
            }
        });

        $(wrapper).on("click", ".remove_field", function(e) { //user click on remove text

            e.preventDefault();
            $(this).parent('div').remove();
            x--;
        })



        $('#qna').submit(function(e) {
            e.preventDefault();


            if ($('.input_fields_wrap').length <= 3) {

                var checkIsCorrect = false;

                for (let i = 0; i < $('.is_correct').length; i++) {
                    if ($('.is_correct:eq(' + i + ')').prop('checked') == true) {
                        //  alert($('.is_correct:eq('+i+')').next().find('input').val());
                        checkIsCorrect = true;
                        //  console.log($('.is_correct:eq(' + i + ')').next().find('input').val());
                        $('.is_correct:eq(' + i + ')').val($('.is_correct:eq(' + i + ')').next().find('input').val());
                    }
                }

                if (checkIsCorrect) {
                    var form = $('#qna')[0];
                    //  console.log(form);
                    var formData = new FormData(form);
                    //  console.log(formData);

                    $.ajax({
                        url: '{{ url("/addqna") }}',
                        type: 'post',
                        data: formData,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        success: function(data) {
                            alert(data.success);
                        },
                        error: function(reject) {
                            //  console.log('rr'.reject);
                            if (reject.status = 422) {

                                // var errors=$.parseJSON(reject.responseText);
                                var errors = reject.responseJSON;
                                $.each(errors.errors, function(key, value) {
                                    $('#' + key).addClass('is-invalid');
                                    $('#' + key + '_help').text(value[0]);
                                })
                            }
                        }
                    })
                } else {
                    $('.error').text('add answers and check one correct');
                    setTimeout(function() {
                        $('.error').text('');
                    }, 2500)
                }



            } else {
                alert('66');
            }


            // if ($('.answers'.length < 2)) {
            //     $('.error').text('add minimum 2 answer');
            //     setTimeout(function() {
            //         $('.error').text('');
            //     }, 2500)
            // } else {
            //     alert("ccc");
            // }
        });

        $('.answerBtn').click(function(e) {
            e.preventDefault();
            var questions = @json($questions);
            console.log(questions);
            var q_id = $(this).data('id');
            var html = '';
            // alert(q_id);
  //aaa
            for (let i = 0; i < questions.length; i++) {
                if (questions[i]['id'] == q_id) {

                    var anslenght = questions[i]['answers'].length;
                    for (let j = 0; j < anslenght; j++) {

                        let is_correct = 'no';
                        if (questions[i]['answers'][j]['is_correct'] == 1) {
                            is_correct = 'yes';
                        }
                        html += `
                        <tr>
                        <td>` + (j + 1) + `</td>
                        <td>` + questions[i]['answers'][j]['answer'] + `</td>
                        <td>` + is_correct + `</td>
                        </tr>
                    `;
                        // console.log(is_correct) 
                    }
                    break;
                }
            }
            $('.showAnswers').html(html);

        })

       //Export Import ajax call
        $('#Import').submit(function(e){
            e.preventDefault();
            var form = $('#Import')[0];
            var formData = new FormData(form);
          //  let formData = new FormData();
           // formData.append("file",fileupload.files[0])
            $.ajax({
                url: "{{ route('importQnA') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success:function(data){
                    if(data.status){
                        alert("success");
                        location.reload();
                    }
                    else{
                        alert('error')
                    }
                },
                error:function(reject){
                  //  alert(reject);
                }
            })
        })



    })
</script>


