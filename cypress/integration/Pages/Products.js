import { PRODUCTS_PAGE, apiUrls  } from "../../common";
//import { readFileSync, writeFileSync } from "fs";

import './../../support/commands';

describe('Products', () => {
    before(() => {
        // runs before each test in the block
        cy.server();
       cy.loginApi();
       
    })

    beforeEach(() => {
        // runs before each test in the block
    })
    
    afterEach(() => {
        // runs after each test in the block
    })

    it('will load all products', () => {
       const token = Cypress.env('token');
        cy.request({
            method: "GET",
            url: apiUrls.products,
            failsOnStatusCode: true,
            headers: {
                "Authorization": "Bearer "+ token ,
                "Accept": "application/json", 
            }
        }).then((response) => {
        if (response.status === 200){
            expect(response.body).to.have.property('data');
           
        }
        }).its('status')
        .should('eq', 200);

    })
    it('will load products with stock details', () => {
        const token = Cypress.env('token');
         cy.request({
             method: "GET",
             url: apiUrls.products_stock,
             failsOnStatusCode: true,
             headers: {
                 "Authorization": "Bearer "+ token ,
                 "Accept": "application/json", 
             }
         }).then((response) => {
         if (response.status === 200){
             expect(response.body).to.have.property('data');
            
         }
         }).its('status')
         .should('eq', 200);
 
     })

     it('will load available products', () => {
        const token = Cypress.env('token');
         cy.request({
             method: "GET",
             url: apiUrls.products_stock_available_only,
             failsOnStatusCode: true,
             headers: {
                 "Authorization": "Bearer "+ token ,
                 "Accept": "application/json", 
             }
         }).then((response) => {
         if (response.status === 200){
             expect(response.body).to.have.property('data');
            
         }
         }).its('status')
         .should('eq', 200);
 
     })
 
    
    
    
    it('will insert new product succcessfully', () => {
        const token = Cypress.env('token');
         cy.request({
             method: "POST",
             url: apiUrls.product_crud,
             failOnStatusCode: false,
             headers: {
                 "Authorization": "Bearer "+ token ,
                 "Accept": "application/json",
             },
             form: true, 
            body: {
                code: 'P5668382',
                name: 'Product 001',
                description: 'This is Product 002'
            }
         }).then((response) => {
         if (response.status === 200){
             expect(response.body).to.have.property('success');
             expect(response.body).property('id').to.not.be.oneOf([null, ""])
              Cypress.env('productId', response.body.id); 

         }
         }).its('status')
         .should('eq', 200);
 
     })

     it('will Delete new inserted product ', () => {
        const token = Cypress.env('token');
        const productId = Cypress.env('productId');

         cy.request({
             method: "Delete",
             url: apiUrls.product_crud + '/'+ productId,
             failOnStatusCode: false,
             headers: {
                 "Authorization": "Bearer "+ token ,
                 "Accept": "application/json",
             },
             form: true, 
            body: {
                id: productId,
            }
         }).then((response) => {
         if (response.status === 200){
             expect(response.body).to.have.property('success');
         }
         }).its('status')
         .should('eq', 200);
 
     })

     it('will return product validation error', () => {
        const token = Cypress.env('token');
         cy.request({
             method: "POST",
             url: apiUrls.product_crud,
             failOnStatusCode: false,
             headers: {
                 "Authorization": "Bearer "+ token ,
                 "Accept": "application/json",
             },
             form: true, 
            body: {
                name: 'Product 001',
                description: 'This is Product 001'
            }
         }).then((response) => {
         if (response.status === 200){
             expect(response.body).to.have.property('success');
         }
         }).its('status')
         .should('eq', 422);
 
     })

 
     


})
