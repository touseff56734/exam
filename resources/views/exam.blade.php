<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
   <meta name="csrf-token" content="{{ csrf_token() }}" />
   <script src="{{ asset('js/multiselect-dropdown.js') }}"></script>
   <title>Document</title>
   <style>
      .multiselect-dropdown{
         width: 100% !important;
      }
   </style>
</head>

<body>
   <h1>

   </h1>

   <div class="container">
      <div class="row">
         <form action="" id="addExam">
            <input type="name" name="exam_name" placeholder="exam name">
            <br><br>
            <select name="subject_id" id="">
               <option value="">select subject</option>
               @foreach($subjects as $subject)
               <option value="{{ $subject->id }}">{{ $subject->name }}</option>
               @endforeach
            </select>
            <br><br>
            <input type="date" name="date" min="@php echo date('Y-m-d'); @endphp">
            <br><br>
            <input type="time" name="time"><br><br>
            <input type="number" min="1" name="attempt" placeholder="Attemp Time"><br><br>
            <input type="submit" value="add">
         </form>
      </div>
      <br><br>
      <table class="table">
         <thead>
            <tr>
               <th>#</th>
               <th>name</th>
               <th>subject</th>
               <th>Attemp Time</th>
               <th>Add Questions</th>
               <th>date</th>
               <th>time</th>
               <th>created at</th>
               <th>Action</th>
            </tr>
         </thead>
         @if(count($exams)>0)
         @foreach($exams as $exam)
         <tr>
            <td>{{ $exam->id }}</td>
            <td>{{ $exam->name }}</td>
            <td>{{ $exam->subject->name }}</td>
            <td>{{ $exam->attempt }}</td>
            <td><a href="#" class="addQuestion" data-id="{{ $exam->id }}" data-toggle="modal" data-target="#addExams">Add Questions</a></td>
            <td>{{ $exam->exam_date }}</td>
            <td>{{ $exam->time }}</td>
            <!-- <td>{{ $exam->created_at->diffForHumans() }}</td> -->
            <td>{{ Carbon\Carbon::parse($exam->created_at)->diffForHumans() }}</td>
            <td><a href="{{ url('/edit-exam',$exam->id) }}" class="btn btn-success" type="button">EDIT</a></td>
         </tr>
         @endforeach
         @endif
      </table>
   </div>

   <!-- Modal for assign Answer -->
   <div class="modal fade" id="addExams" role="dialog">
      <div class="modal-dialog">

         <!-- Modal content-->
         <div class="modal-content">
            <form action="" id="addQna" >
               <div class="modal-header">
               <h4 class="modal-title">Add QnA</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  
               </div>

               <div class="modal-body">
                  <input type="hidden" name="exam_id" id="addExamId">
                  <input type="search" type="search" class="w-100" placeholder="Search Here">
                   <br><br>
                   <table class="table">
                     <thead>
                        <th>Select</th>
                        <th>Question</th>
                     </thead>
                     <tbody class="addBody">

                     </tbody>
                   </table>

                  <!-- <select name="questions" multiple multiselect-search="true"  multiselect-select-all="true" onchange="console.log(this.selectedOptions)">
                     <option value="">asd</option>
                     <option value="a">aa</option>
                  </select> -->
               </div>
               <div class="modal-footer">
                  <button type="submit" class="btn btn-success">Add QnA</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               </div>
            </form>
         </div>
      </div>
   </div>



</body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

</html>

<script>
   $(document).ready(function() {
      $.ajaxSetup({
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
      });
      $('#addExam').submit(function(e) {
         e.preventDefault();
         var form = $(this).serialize();
         // alert(form);
         $.ajax({
            url: '{{ url("addexam") }}',
            data: form,
            type: 'POST',
            success: function(data) {
               if (data == 1) {
                  alert('Data has been inserted');
               }
            },
            error: function(err) {
               console.log(err);
            }
         })

      })
      //add qna exam

      $('.addQuestion').click(function(){
         var exam_id = $(this).data('id');
         $('#addExamId').val(exam_id);

         $.ajax({
            url: "{{ route('getQuestions') }}",
            type: "GET",
            data: {exam_id : exam_id},
            success: function(data){
               if(data.success == true){
                   var questions = data.data;
                   var html = '';
                   if(questions.length > 0){
                      for(let i=0; i<questions.length; i++){
                        html += `<tr>
                                 <td><input type='checkbox' value="`+questions[i]['id']+`" name="questions_ids[]"></td>
                                 <td>`+questions[i]['question']+`</td>
                                 </tr>`;
                      }

                      
                   }
                   else {
                     html += `<tr><td colspan='2'>Question Not found</td></tr>`
                   }
                   $(".addBody").html(html);
               }
               else{
                  alert(data.msg);
               }
            }
         })

      })

      //add qna

      $('#addQna').submit(function(e) {
         e.preventDefault();
         var form = $(this).serialize();
         // alert(form);
         $.ajax({
            url: '{{ route("addQuestions") }}',
            data: form,
            type: 'POST',
            success: function(data) {
               if (data == 1) {
                  alert('Data has been inserted');
               }
            },
            error: function(err) {
               console.log(err);
            }
         })

      })

   });
</script>