@extends('layout.common')

@section('content')
<section id="typography">
    <table id="example" class="display" style="width:100%">
        <thead>
        <tr>
            <th>オンエアー日付</th>
            <th>出演者名</th>
            <th>曲名</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>オンエアー日付</th>
            <th>出演者名</th>
            <th>曲名</th>
        </tr>
        </tfoot>
    </table>
</section>

<script>
    window.onload = function () {

        $('#example').DataTable({
            "ajax": '/api/castings',
            "columns": [
                {"width": "70px"},
                null,
                null
            ],
            language: {
                url: "http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Japanese.json"
            }
        });

    };
</script>
@endsection
