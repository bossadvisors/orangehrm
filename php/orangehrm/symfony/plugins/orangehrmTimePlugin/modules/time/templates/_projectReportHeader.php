<table>
     <tr><td style="width: 80px;"><?php echo " Project Name";?></td><td><?php echo $projectName;?></td></tr>
     <?php if(!(($projectDateRangeFrom == "YYYY-MM-DD") || ($projectDateRangeFrom  == ""))) {?><tr><t<td style="width: 80px;"><?php echo " From ";?></td><td><?php echo $projectDateRangeFrom;?></td></tr><?php } ?>
     <?php if(!(($projectDateRangeTo == "YYYY-MM-DD") || ($projectDateRangeTo  == ""))) {?><tr><td style="width: 80px;"><?php echo " To ";?></td><td><?php echo $projectDateRangeTo;?></td></tr><?php } ?>
</table>
