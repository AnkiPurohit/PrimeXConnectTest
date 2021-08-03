import {SITE_URL, LOGIN_DATA, LOGOUT_PAGE, PRODUCTS_PAGE, apiUrls} from './../common.js';

/**
 * Login helper function.
 */
 Cypress.Commands.add('login', () => {
    cy.visit(SITE_URL);
    cy.get('input[id="email"]').type(LOGIN_DATA.username);
    cy.get('input[id="password"]').type(LOGIN_DATA.password);
    cy.get('button[type="submit"]').click();
    cy.url().should('contains', PRODUCTS_PAGE)
 });
 

 Cypress.Commands.add('loginApi', () => {
   cy.request({
       method: "POST",
       url: apiUrls.login,
       form: true, 
       body: {
         email: LOGIN_DATA.username,
         password: LOGIN_DATA.password,
       }
   }).then((response) => {
      if (response.status === 200 && response.body.success === true){
         Cypress.env('token', response.body.token); 
      }
    }).its('status')
    .should('eq', 200);
});

/**
 * Logout helper function.
 */
 Cypress.Commands.add('logout', () => {
    cy.get('.logout').click();
    cy.url().should('contains', SITE_URL)
 });

