<table>
    <thead>
        <tr>
            <th>Unidad Negocio</th>
            <th>Meta Unidad</th>
            <th>Porcentaje Unidad</th>
            <th>Meta_Director</th>
            <th>Porcentaje Director</th>
            <th>Meta Comerciales</th>
            <th>Porcentaje_Comerciales</th>
            <th>Q1_%</th>
            <th>Q2_%</th>
            <th>Q3_%</th>
            <th>Q4_%</th>
            <th>Q1_$</th>
            <th>Q2_$</th>
            <th>Q3_$</th>
            <th>Q4_$</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($budgets as $budget)
            <tr>
                <td>{{ $budget->businessUnit }}</td>
                <td>{{ $budget->goal }}</td>
                <td>{{ $budget->goalPercent }}</td>
                <td>{{ $budget->goalDirector }}</td>
                <td>{{ $budget->goalDirectorPercent }}</td>
                <td>{{ $budget->goalCommercial }}</td>
                <td>{{ $budget->commercialPercent }}</td>
                <td>{{ $budget->q1Percent }}</td>
                <td>{{ $budget->q2Percent }}</td>
                <td>{{ $budget->q3Percent }}</td>
                <td>{{ $budget->q4Percent }}</td>
                <td>{{ $budget->q1 }}</td>
                <td>{{ $budget->q2 }}</td>
                <td>{{ $budget->q3 }}</td>
                <td>{{ $budget->q4 }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
