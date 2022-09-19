<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h1>
  Edit Exam
</h1>

<div class="container">
   <div class="row">
      <form action="" id="addExam">
        <input type="hidden" name="exam_id" value="{{ $exam->id }}">
         <input type="name" name="exam_name" placeholder="exam name" value="{{ $exam->name }}">
         <br><br>
         <select name="subject_id" id="">
            <option value="">select subject</option>
            @foreach($subjects as $subject)
            <option {{ $subject->id == $exam->subject_id ? 'selected' : '' }} value="{{ $subject->id }}">{{ $subject->name }}</option>
            @endforeach
         </select>
         <br><br>
         <input type="date" value="{{ $exam->exam_date }}" name="date" min="@php echo date('Y-m-d'); @endphp">
         <br><br>
         <input type="time" value="{{ $exam->time }}" name="time"><br><br>
         <input type="number" value="{{ $exam->attempt }}" min="1" name="attempt" placeholder="Attemp Time"><br><br>
         <input type="submit" value="add">
      </form>
   </div>
</body>
</html>