<?php foreach($items as $item):
    if($kategorie['id'] == $item['kategorie_id']): ?>
                                
        <li class="todo"><a href="php/mark.php?as=<?php echo $item['done'] == 0 ? 'done' : 'notdone'; ?>&todo=<?php echo $item['id']; ?>" class="<?php echo $item['done'] ? ' done' : ''; ?>"><?php echo $item['name']; ?></a>
            <span class="close">×</span>
        </li>
    <?php endif; ?>   
 <?php endforeach; ?>
<?php unset($item); ?>