<br/>
<?php if (count($input) > 0): ?>
<table style="border: 1px solid black;border-collapse: collapse;">
    
      
<?php foreach ($input as $desc => $val): ?>
      <tr>
	      <th style="padding: 5px;text-align: left;border: 1px solid black;border-collapse: collapse;">
	      	{{ $desc }}
	      </th>
	      <td style="padding: 5px;text-align: left;border: 1px solid black;border-collapse: collapse;">
	      	{{ is_array($val) ? json_encode($val) : $val }}
	      </td>
      </tr>
<?php endforeach; ?>
      
    
  </tbody>
</table>
<?php endif; ?>