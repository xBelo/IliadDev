import { Products } from "./products.model";

export interface Order {
    id: number;
    name: string;
    description: string;
    date: Date;
    products: Products[]|null
  }