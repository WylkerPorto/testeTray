export interface ISale {
  uid: string;
  seller_id: string;
  seller: {
    name: string;
    email: string;
    created_at: string;
  };
  value: string;
  sale_date: string;
  created_at: string;
  updated_at: string;
}
