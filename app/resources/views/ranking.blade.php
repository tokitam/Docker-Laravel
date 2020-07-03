@extends('layout.common')

@section('content')
    <section id="typography">
        <table id="example1" class="display" style="width:100%">
            <thead>
            <tr>
                <th>順位</th>
                <th>出演者名</th>
                <th>出演回数</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>順位</th>
                <th>出演者名</th>
                <th>出演回数</th>
            </tr>
            </tfoot>
        </table>
    </section>

<section id="typography">
    <table id="example2" class="display" style="width:100%">
        <thead>
        <tr>
            <th>順位</th>
            <th>出演者名</th>
            <th>出演回数</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>順位</th>
            <th>出演者名</th>
            <th>出演回数</th>
        </tr>
        </tfoot>
    </table>
</section>

<section id="typography">
    <table id="example3" class="display" style="width:100%">
        <thead>
        <tr>
            <th>順位</th>
            <th>出演者名</th>
            <th>出演回数</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>順位</th>
            <th>出演者名</th>
            <th>出演回数</th>
        </tr>
        </tfoot>
    </table>
</section>

<script>
    window.onload = function () {
        $('#example1').DataTable({
            "ajax": '/api/ranking?from=1990-01-01&to=2000-01-01',
            "columns": [
                {"width": "25px"},
                null,
                null
            ],
            language: {
                url: "/js/Japanese.json"
            }
        });

        $('#example2').DataTable({
            "ajax": '/api/ranking?from=2000-01-01&to=2010-01-01',
            "columns": [
                {"width": "25px"},
                null,
                null
            ],
            language: {
                url: "/js/Japanese.json"
            }
        });

        $('#example3').DataTable({
            "ajax": '/api/ranking?from=2010-01-01&to=2020-01-01',
            "columns": [
                {"width": "25px"},
                null,
                null
            ],
            language: {
                url: "/js/Japanese.json"
            }
        });
    };
</script>
@endsection
