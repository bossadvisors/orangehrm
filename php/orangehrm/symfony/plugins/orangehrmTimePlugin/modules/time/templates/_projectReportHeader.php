<table>
     <tr><td style="width: 80px;"><?php echo " Project Name";?></td><td><?php echo $projectName;?></td></tr>
     <?php if(!(($projectDateRangeFrom == "YYYY-MM-DD") || ($projectDateRangeFrom  == ""))) {?><tr><td style="width: 80px;"><?php echo " From ";?></td><td><?php echo set_datepicker_date_format($projectDateRangeFrom);?></td></tr><?php } ?>
     <?php if(!(($projectDateRangeTo == "YYYY-MM-DD") || ($projectDateRangeTo  == ""))) {?><tr><td style="width: 80px;"><?php echo " To ";?></td><td><?php echo set_datepicker_date_format($projectDateRangeTo);?></td></tr><?php } ?>
</table>
