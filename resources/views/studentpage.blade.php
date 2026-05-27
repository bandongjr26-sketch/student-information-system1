@extends('layout.format')

@section('title', 'Students')

@section('content')
<h2>Student List</h2>

<!-- Add 'table-striped' for zebra effect -->
<table class="table table-bordered table-striped">
    <thead class="table-primary">
        <tr>
            <th>No.</th>
            <th>Name</th>
            <th>Age</th>
            <th>Course</th>
            <th>Level</th> 
        </tr>
    </thead>
    <tbody>
        @forelse($studentN as $student)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $student['name'] }}</td>
                <td>{{ $student['age'] }}</td>
                <td>{{ $student['course'] }}</td>
                <td>
                    @if($student['age'] == 19)
                        Freshman Student
                    @elseif($student['age'] == 20)
                        Sophomore
                    @elseif($student['age'] == 21)
                        Junior Student
                    @elseif($student['age'] == 22)
                        Senior Student
                    @else
                        Unknown level
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5">No students found</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection