context("Login", () => {
  describe("template spec", () => {
    beforeEach(() => {
      cy.visit("https://www.saucedemo.com");
      // it("login", () => {
      cy.get("#user-name").type("standard_user");
      cy.get("#password").type("secret_sauce");
      cy.get("form").submit();

      // Проверка, что пользователь успешно авторизован
      cy.url().should("include", "/inventory.html");
      cy.get(".title").should("contain", "Products");
      // });
    });

    it("asc", () => {
      cy.get(".product_sort_container").select("lohi");

      cy.get(".inventory_list .inventory_item").then((items) => {
        const firstItemPriceText = items
          .eq(0)
          .find(".inventory_item_price")
          .text();

        const secondItemPriceText = items
          .eq(1)
          .find(".inventory_item_price")
          .text();

        const firstItemPrice = parseFloat(
          firstItemPriceText.replace(/[^\d]/g, "")
        );
        const secondItemPrice = parseFloat(
          secondItemPriceText.replace(/[^\d]/g, "")
        );

        expect(secondItemPrice).to.be.greaterThan(firstItemPrice);
      });
    });
    it("desc", () => {
      cy.get(".product_sort_container").select("hilo");

      cy.get(".inventory_list .inventory_item").then((items) => {
        const firstItemPriceText = items
          .eq(0)
          .find(".inventory_item_price")
          .text();

        const secondItemPriceText = items
          .eq(1)
          .find(".inventory_item_price")
          .text();

        const firstItemPrice = parseFloat(
          firstItemPriceText.replace(/[^\d]/g, "")
        );
        const secondItemPrice = parseFloat(
          secondItemPriceText.replace(/[^\d]/g, "")
        );

        expect(firstItemPrice).to.be.greaterThan(secondItemPrice);
      });
    });
    it("cart", () => {
      cy.get(".inventory_list .inventory_item").then((items) => {
        expect(items).to.have.length.greaterThan(1);

        cy.wrap(items[0]).find("#add-to-cart-sauce-labs-backpack").click();
        cy.wrap(items[1]).find("#add-to-cart-sauce-labs-bike-light").click();
      });
      cy.get(".shopping_cart_badge").should("have.text", "2");
      cy.get(".shopping_cart_link").click();
      cy.url().should("include", "/cart.html");

      cy.get(".cart_list .cart_item").then((items) => {
        expect(items).to.have.length.greaterThan(1);
      });

      cy.get("#checkout").click();
      cy.url().should("include", "/checkout-step-one.html");

      cy.get("#first-name").type("User");
      cy.get("#last-name").type("User");
      cy.get("#postal-code").type("123456");
      cy.get("#continue").click();
      cy.url().should("include", "/checkout-step-two.html");

      cy.get(".cart_list .cart_item").then((items) => {
        expect(items).to.have.length.greaterThan(1);
      });

      cy.get("#finish").click();

      cy.url().should("include", "/checkout-complete.html");
      cy.get(".complete-header").should(
        "have.text",
        "Thank you for your order!"
      );
    });
  });
});
