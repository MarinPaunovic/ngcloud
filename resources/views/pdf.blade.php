<form action="{{ route('pdf.download') }}" method="POST">
    @csrf
    <div class="groupContainer">
        <table class="table table-bordered mb-5">
            <thead>
                <tr class="table-danger">
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">DOB</th>
                    <th> <input type="checkbox" id="checkAll" class="all_checked" onchange> Check All<br></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <th scope="row">{{ $user->id }}</th>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->surname }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        <td><input type="checkbox" id="{{ $user->id }}" name="checkbox{{ $user->id }}"
                                class="checkbox" /></td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-end mb-4">
        <button type="submit" class="btn btn-primary">Export to PDF</a>
    </div>
</form>


<script>
    document.addEventListener("click", function(e) {
        const target = e.target
        if (target.type === "checkbox" && target.id.startsWith('checkAll')) {
            const checked = target.checked;
            const parent = target.closest(".groupContainer");
            const checks = parent.querySelectorAll("input[type=checkbox]");
            [...checks].map(check => {
                if (!check.disabled) check.checked = checked;
            })
        }
    });
</script>
