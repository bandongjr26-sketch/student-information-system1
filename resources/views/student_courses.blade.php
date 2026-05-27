<!DOCTYPE html>
<html>
<head>
    <title>Student Courses</title>
</head>
<body>
    <h1>Your Courses</h1>
    @if(isset($courses) && $courses->count() > 0)
        @foreach($courses as $course)
            <div>
                <h3>{{ $course->name ?? $course->title ?? 'Untitled' }}</h3>
                <p>{{ $course->description ?? '' }}</p>
            </div>
        @endforeach
    @else
        <p>No courses enrolled.</p>
    @endif
</body>
</xai:function_call >  

<xai:function_call name="read_file">
<parameter name="path">c:/Users/bando/JRCBprojecta/resources/views/student_courses.blade.php
