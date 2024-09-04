import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router, RouterLink, RouterOutlet } from '@angular/router';
import { HttpClientModule } from '@angular/common/http';
import { ClarityModule } from '@clr/angular';
import { CommonModule } from '@angular/common';
import { OrderService } from '../../services/order.service';
import { Order } from '../../models/order.model';
import { FormsModule } from '@angular/forms';


@Component({
  selector: 'app-order-edit',
  standalone: true,
  imports: [HttpClientModule, ClarityModule, CommonModule, FormsModule, RouterLink, RouterOutlet],
  templateUrl: './order-edit.component.html',
  styleUrl: './order-edit.component.css'
})
export class OrderEditComponent implements OnInit {
  order: Order = {
    id: 0,
    name: '',
    description: '',
    date: new Date,
    products: null
  };

  constructor(
    private orderService: OrderService,
    private route: ActivatedRoute,
    private router: Router
  ) { }

  ngOnInit(): void {
    const id = Number(this.route.snapshot.paramMap.get('id'));
    if (id) {
      this.orderService.getOrder(id).subscribe(
        order => this.order = order,
        error => console.error('Error fetching order:', error)
      );
    }
  }

  onSubmit(): void {
    this.orderService.updateOrder(this.order.id, this.order).subscribe(
      () => this.router.navigate(['/api/order/view', this.order.id]),
      error => console.error('Error updating order:', error)
    );
  }
}