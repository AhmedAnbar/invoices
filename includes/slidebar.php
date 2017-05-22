<div off-canvas="slidebar-1 left reveal">
  <ul class="nav sidebar-nav">
      <li class="sidebar-brand">
          <a href="/index.php">
             MLMSystem
          </a>
      </li>
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Invoices<span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li class="dropdown-header">Manage Invoices</li>
            <li><a href="<?php linkto('pages/invoices/create_invoice.php'); ?>">Create Invoice</a></li>
            <li><a href="<?php linkto('pages/invoices/change_invoice.php'); ?>">Change Invoice</a></li>
            <li><a href="<?php linkto('pages/invoices/display_invoice.php'); ?>">Display Invoice</a></li>
            <li><a href="<?php linkto('pages/invoices/display_invoices.php'); ?>">Display Invoices - List</a></li>
          </ul>
      </li>
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Work Orders<span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li class="dropdown-header">Manage Orders</li>
            <li><a href="<?php linkto('pages/orders/create_order.php'); ?>">Create Order</a></li>
            <li><a href="<?php linkto('pages/orders/change_order.php'); ?>">Change Order</a></li>
            <li><a href="<?php linkto('pages/orders/display_order.php'); ?>">Display Order</a></li>
            <li><a href="<?php linkto('pages/orders/display_orders.php'); ?>">Display Orders - List</a></li>
          </ul>
      </li>
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Equipment<span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li class="dropdown-header">Manage Equipment</li>
            <li><a href="<?php linkto('pages/equipments/create_equipment.php'); ?>">Create Equipment</a></li>
            <li><a href="<?php linkto('pages/equipments/change_equipment.php'); ?>">Change Equipment</a></li>
            <li><a href="<?php linkto('pages/equipments/display_equipment.php'); ?>">Display Equipment</a></li>
            <li><a href="<?php linkto('pages/equipments/display_equipments.php'); ?>">Display Equipments - List</a></li>
          </ul>
      </li>
      <div class="space"></div>


  </ul>
 
