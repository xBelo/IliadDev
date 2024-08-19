// src/app/app-routing.module.ts
import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { OrderListComponent } from './components/order-list/order-list.component';
import { OrderCreateComponent } from './components/order-create/order-create.component';
import { OrderEditComponent } from './components/order-edit/order-edit.component';
import { OrderDetailComponent } from './components/order-detail/order-detail.component';

export const routes: Routes = [
  { path: 'api/order', component: OrderListComponent },
  { path: 'api/order/create', component: OrderCreateComponent },
  { path: 'api/order/edit/:id', component: OrderEditComponent },
  { path: 'api/order/view/:id', component: OrderDetailComponent },
  { path: '', component: OrderListComponent }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
