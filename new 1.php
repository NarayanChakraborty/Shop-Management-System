<html>

<head><script language="javascript" src="js/jquery-3.1.0.min.js"  ></script>
</head>
<body>
<tr>
    <td>
        <input class="" title="jan" id="" name="r_inpatient_jan" value="" size="4" maxlength="4" />
    </td>
    <td>
        <input class="" title="feb" id="" name="r_inpatient_feb" value="" size="4" maxlength="4" />
    </td>
    <td>
        <input class="" title="tot" id="" name="r_inpatient_tot" value="0" size="4" maxlength="4" disabled/>
    </td>
</tr>
<script>
$("input[name^=r_inpatient]").keyup(function() {
    var sum = 0;
    $("input[name^=r_inpatient]").not("input[name=r_inpatient_tot]").each(function() {
        var number = parseInt(this.value) || 0;
        sum += parseInt(number);
    });
    $("input[name=r_inpatient_tot]").val(sum);
});
</script>

</body>

