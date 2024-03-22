CREATE TABLE
   Department (
      Dept_ID varchar(3),
      Dept_name varchar(22),
      constraint pk_dept primary key (Dept_ID)
   );

CREATE TABLE
   Department_Manager (
      Emp_manager varchar(4),
      Dept_ID varchar(3),
      PRIMARY KEY (Emp_manager),
      CONSTRAINT fk_dept_id FOREIGN KEY (Dept_ID) REFERENCES Department (Dept_ID)
   );

CREATE TABLE
   Employee (
      Emp_ID varchar(4),
      Emp_Fname varchar(18),
      Emp_Lname varchar(18),
      Emp_Tel varchar(11),
      Emp_role varchar(18),
      Emp_salary int,
      Emp_HNo varchar(12),
      Emp_city varchar(12),
      Emp_street varchar(18),
      Emp_zipcode varchar(5),
      Emp_manager varchar(4),
      CONSTRAINT pk_emp PRIMARY KEY (Emp_ID),
      CONSTRAINT fk_emp_mgr FOREIGN KEY (Emp_manager) REFERENCES Employee (Emp_ID),
      CONSTRAINT fk_emp_mgr_d FOREIGN KEY (Emp_manager) REFERENCES Department_Manager (Emp_manager)
   );

CREATE TABLE
   Customer (
      Cus_ID varchar(4),
      Cus_Fname varchar(18),
      Cus_Lname varchar(18),
      Cus_Tel varchar(11),
      Cus_Content varchar(9),
      Cus_HNo varchar(12),
      Cus_city varchar(12),
      Cus_street varchar(18),
      Cus_zipcode varchar(5),
      Emp_ID varchar(4),
      constraint pk_cus primary key (Cus_ID),
      constraint fk_emp_cus foreign key (Emp_ID) references Employee (Emp_ID)
   );

CREATE TABLE
   Project (
      Project_ID varchar(5),
      P_name varchar(8),
      constraint pk_project_id primary key (Project_ID)
   );

CREATE TABLE
   Bill (
      Bill_ID varchar(6),
      Pay_50 int,
      Pay_30 int,
      Pay_20 int,
      Status_50 varchar(10),
      Status_30 varchar(10),
      Status_20 varchar(10),
      Slip_50 BLOB,
      Slip_30 BLOB,
      Slip_20 BLOB,
      DatePay_50 date,
      DatePay_30 date,
      DatePay_20 date,
      Cus_ID varchar(4),
      CONSTRAINT pk_Bill_ID PRIMARY KEY (Bill_ID),
      CONSTRAINT fk_cus_id_bill FOREIGN KEY (Cus_ID) REFERENCES Customer (Cus_ID)
   );

CREATE TABLE
   Quotation (
      Quot_ID varchar(4),
      Net_Price int,
      Quot_date date,
      Quot_detail varchar(1000),
      Cus_ID varchar(4),
      Project_ID varchar(5),
      Bill_ID varchar(6),
      constraint pk_quot_id primary key (Quot_ID),
      CONSTRAINT fk_cus_id_qout FOREIGN KEY (Cus_ID) REFERENCES Customer (Cus_ID),
      CONSTRAINT fk_project_id_qout FOREIGN KEY (Project_ID) REFERENCES Project (Project_ID),
      CONSTRAINT fk_bill_id_qout FOREIGN KEY (Bill_ID) REFERENCES Bill (Bill_ID)
   );

CREATE TABLE
   Production_Order (
      PO_ID varchar(6),
      PO_month varchar(4),
      PO_detail varchar(1000),
      constraint pk_po_id primary key (PO_ID)
   );

CREATE TABLE
   Supplier (
      Sup_ID varchar(3),
      Sup_name varchar(50),
      Sup_Tel varchar(11),
      Sup_HNo varchar(12),
      Sup_city varchar(12),
      Sup_street varchar(18),
      Sup_zipcode varchar(5),
      Project_ID varchar(5),
      constraint pk_sup_id primary key (Sup_ID),
      CONSTRAINT fk_project_id_pj FOREIGN KEY (Project_ID) REFERENCES Project (Project_ID)
   );

CREATE TABLE
   Material (
      M_SKU varchar(30),
      M_name varchar(20),
      M_Stock int,
      M_numStock int,
      M_price int,
      constraint pk_MID_Color_Size primary key (M_SKU)
   );

CREATE TABLE
   Material_Use (
      M_SKU varchar(30),
      Quot_ID varchar(4),
      Use_num int,
      constraint pk_quot_id_m_sku primary key (M_SKU, Quot_ID),
      CONSTRAINT fk_sku_mu FOREIGN KEY (M_SKU) REFERENCES Material (M_SKU),
      CONSTRAINT fk_quot_mu FOREIGN KEY (Quot_ID) REFERENCES Quotation (Quot_ID)
   );

CREATE TABLE
   Area_Measurement_Sheet (
      AMS_ID varchar(6),
      AMS_time varchar(4),
      AMS_date date,
      Loc_HNo varchar(12),
      Loc_city varchar(12),
      Loc_street varchar(18),
      loc_zipcode varchar(5),
      Quot_ID varchar(4),
      constraint pk_ams_id primary key (AMS_ID),
      CONSTRAINT fk_ams_quot_id FOREIGN KEY (Quot_ID) REFERENCES Quotation (Quot_ID)
   );

CREATE TABLE
   Managment_Quottaiont_Employee (
      Emp_ID varchar(4),
      Quot_ID varchar(4),
      constraint pk_mqe primary key (Emp_ID, Quot_ID),
      CONSTRAINT fk_emp_id_mqe FOREIGN KEY (Emp_ID) REFERENCES Employee (Emp_ID),
      CONSTRAINT fk_quot_ig_mqe FOREIGN KEY (Quot_ID) REFERENCES Quotation (Quot_ID)
   );

CREATE TABLE
   Quot_Cus (
      Quot_ID varchar(4),
      Cus_ID varchar(4),
      constraint pk_mqe primary key (Quot_ID),
      CONSTRAINT fk_quot_id_qc FOREIGN KEY (Quot_ID) REFERENCES Quotation (Quot_ID),
      CONSTRAINT fk_cus_ig_qc FOREIGN KEY (Cus_ID) REFERENCES Customer (Cus_ID)
   );

CREATE TABLE
   Material_PO (
      M_SKU varchar(30),
      PO_ID varchar(6),
      constraint pk_sku_po_mp primary key (M_SKU, PO_ID),
      CONSTRAINT fk_sku_mp FOREIGN KEY (M_SKU) REFERENCES Material (M_SKU),
      CONSTRAINT fk_po_id_mp FOREIGN KEY (PO_ID) REFERENCES Production_Order (PO_ID)
   );

CREATE TABLE
   MakingOrder_Customer_Project (
      Cus_ID varchar(4),
      Project_ID varchar(5),
      constraint pk_cus_pj_make primary key (Cus_ID, Project_ID),
      CONSTRAINT fk_cus_id_make FOREIGN KEY (Cus_ID) REFERENCES Customer (Cus_ID),
      CONSTRAINT fk_project_id_make FOREIGN KEY (Project_ID) REFERENCES Project (Project_ID)
   );

CREATE TABLE
   Material_Area_Measurement_Sheet (
      AMS_ID varchar(6),
      M_SKU varchar(30),
      constraint pk_ams_sku_mams primary key (AMS_ID, M_SKU),
      CONSTRAINT fk_ams_mams FOREIGN KEY (AMS_ID) REFERENCES Area_Measurement_Sheet (AMS_ID),
      CONSTRAINT fk_sku FOREIGN KEY (M_SKU) REFERENCES Material (M_SKU)
   );

CREATE TABLE
   Sending_Materal (
      Sup_ID varchar(3),
      M_SKU varchar(30),
      constraint pk_sup_sku_sm primary key (Sup_ID, M_SKU),
      CONSTRAINT fk_sup_id_sm FOREIGN KEY (Sup_ID) REFERENCES Supplier (Sup_ID),
      CONSTRAINT fk_sku_sm FOREIGN KEY (M_SKU) REFERENCES Material (M_SKU)
   );

CREATE TABLE
   AMS_Project (
      AMS_ID varchar(3),
      Project_ID varchar(30),
      Measurement varchar(14),
      constraint pk_ams_pj_ap primary key (AMS_ID, Project_ID),
      CONSTRAINT fk_project_id_ap FOREIGN KEY (Project_ID) REFERENCES Project (Project_ID),
      CONSTRAINT fk_ams_id_ap FOREIGN KEY (AMS_ID) REFERENCES Area_Measurement_Sheet (AMS_ID)
   );