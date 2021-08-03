import {SITE_URL, LOGIN_DATA, PRODUCTS_PAGE, apiUrls} from './../../common.js';

describe('Authenticaation', () => {

    before(() => {
        // runs once before all tests in the block
        cy.server();
    })

    beforeEach(() => {
        // runs before each test in the block
    })

    afterEach(() => {
        // runs after each test in the block
    })

    after(() => {
        // runs once after all tests in the block
    })

    it('will open login page', () => {
        cy.visit(SITE_URL);
        cy.login();

        cy.wait(3000);
        cy.logout();
    })

})