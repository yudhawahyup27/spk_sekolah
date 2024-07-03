<!DOCTYPE html>
<html>
<head>
    <title>Daftar Siswa</title>
</head>
<body>
    @if (session('success'))
        <div>
            {{ session('success') }}
        </div>
    @endif

    <h1>Daftar Siswa</h1>

    <a href="{{ route('students.import') }}">
        <button>Import Data</button>
    </a>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Code</th>
                <th>Name</th>
                <th>Gender</th>
                <th>Grade</th>
                <th>Year</th>
            </tr>
        </thead>
        <tbody>
            @foreach($studentData as $student)
                <tr>
                    <td>{{ $student->id }}</td>
                    <td>{{ $student->code }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->gender }}</td>
                    <td>{{ $student->grade->name }}</td>
                    <td>{{ $student->year->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
