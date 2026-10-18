<?php
$btn = get_field('cart_btn') ?? '';
$note = get_field('cart_note') ?? '';
?>
<div class="cart">
	<div class="cart__layout">
		<form class="cart__form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">

			<?php do_action('woocommerce_before_cart_table'); ?>

			<div class="cart__items">
				<?php do_action('woocommerce_before_cart_contents'); ?>

				<?php
				foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
					$_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
					$product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

					if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
						?>

						<div class="cart-item card-box" data-cart-item-key="<?php echo esc_attr($cart_item_key); ?>">

							<div class="cart-item__thumbnail">
								<?php
								$product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
								if ($product_permalink) {
									echo '<a href="' . esc_url($product_permalink) . '">' . $_product->get_image() . '</a>';
								} else {
									echo $_product->get_image();
								}
								?>
							</div>

							<div class="cart-item__info">
								<?php
								$categories = get_the_terms($product_id, 'product_cat');
								if ($categories && !is_wp_error($categories)) {
									$category = array_shift($categories);
									$category_link = get_term_link($category);
									if (!is_wp_error($category_link)) {
										echo '<div class="cart-item__category">';
										echo '<a href="' . esc_url($category_link) . '">' . esc_html($category->name) . '</a>';
										echo '</div>';
									}
								}
								?>

								<div class="cart-item__title">
									<?php
									if ($product_permalink) {
										echo '<a href="' . esc_url($product_permalink) . '">';
									}
									echo wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key));
									if ($product_permalink) {
										echo '</a>';
									}

									// Атрибуты вариации
									if ($_product->is_type('variation') && !empty($cart_item['variation'])) {
										echo '<div class="cart-item__variations">';

										foreach ($cart_item['variation'] as $attribute_name => $attribute_value) {
											if (empty($attribute_value)) {
												continue;
											}

											$clean_name = str_replace('attribute_', '', $attribute_name);
											$is_taxonomy = taxonomy_exists($clean_name);
											$attribute_label = wc_attribute_label($clean_name, $_product);

											if ($is_taxonomy) {
												$term = get_term_by('slug', $attribute_value, $clean_name);
												$attribute_display_value = $term ? $term->name : $attribute_value;
											} else {
												$attribute_display_value = $attribute_value;
											}

											echo '<span class="cart-item__variation">';
											echo esc_html($attribute_label) . ': <strong>' . esc_html($attribute_display_value) . '</strong>';
											echo '</span>';
										}

										echo '</div>';
									}

									echo apply_filters('woocommerce_cart_item_meta', '', $cart_item, $cart_item_key);
									?>
								</div>
							</div>

							<div class="cart-item__quantity">
								<?php
								if ($_product->is_sold_individually()) {
									$min_input = 1;
									$max_input = 1;
								} else {
									$min_input = 0;
									$max_input = $_product->get_max_purchase_quantity();
								}
								?>
								<div class="quantity-input">
									<button type="button" class="quantity-input__btn quantity-input__btn--minus"
										data-cart-item-key="<?php echo esc_attr($cart_item_key); ?>">-</button>
									<input type="number" class="quantity-input__field"
										name="cart[<?php echo esc_attr($cart_item_key); ?>][qty]"
										value="<?php echo esc_attr($cart_item['quantity']); ?>"
										min="<?php echo esc_attr($min_input); ?>" max="<?php echo esc_attr($max_input); ?>" step="1"
										data-cart-item-key="<?php echo esc_attr($cart_item_key); ?>" />
									<button type="button" class="quantity-input__btn quantity-input__btn--plus"
										data-cart-item-key="<?php echo esc_attr($cart_item_key); ?>">+</button>
								</div>
							</div>

							<div class="cart-item__price">
								<?php
								echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
								?>
							</div>

							<div class="cart-item__remove">
								<?php
								echo apply_filters(
									'woocommerce_cart_item_remove_link',
									sprintf(
										'<a href="%s" class="cart-item__remove-btn icon icon--remove" aria-label="%s" data-cart-item-key="%s" data-product_id="%s" data-product_sku="%s">×</a>',
										esc_url(wc_get_cart_remove_url($cart_item_key)),
										esc_html__('Remove this item', 'woocommerce'),
										esc_attr($cart_item_key),
										esc_attr($product_id),
										esc_attr($_product->get_sku())
									),
									$cart_item_key
								);
								?>
							</div>

						</div>
						<?php
					}
				}
				?>

				<?php do_action('woocommerce_cart_contents'); ?>
			</div>

			<?php do_action('woocommerce_after_cart_contents'); ?>
			<?php do_action('woocommerce_after_cart_table'); ?>

			<div class="cart__actions">
				<?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
				<a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="cart__continue-shopping">
					Продолжить покупки
				</a>
			</div>

		</form>

		<div class="cart__sidebar card-box">
			<div class="cart-totals">
				<h2 class="cart-totals__title title-5">Ваш заказ</h2>

				<div class="cart-totals__row">
					<span>Товары (<span data-cart-count><?php echo WC()->cart->get_cart_contents_count(); ?></span>)</span>
					<span data-cart-subtotal><?php echo WC()->cart->get_cart_subtotal(); ?></span>
				</div>

				<?php foreach (WC()->cart->get_coupons() as $code => $coupon): ?>
					<div class="cart-totals__row cart-totals__row--coupon">
						<span><?php wc_cart_totals_coupon_label($coupon); ?></span>
						<span><?php wc_cart_totals_coupon_html($coupon); ?></span>
					</div>
				<?php endforeach; ?>

				<?php foreach (WC()->cart->get_fees() as $fee): ?>
					<div class="cart-totals__row cart-totals__row--fee">
						<span><?php echo esc_html($fee->name); ?></span>
						<span><?php wc_cart_totals_fee_html($fee); ?></span>
					</div>
				<?php endforeach; ?>

				<?php if (wc_tax_enabled() && !WC()->cart->display_prices_including_tax()): ?>
					<?php if ('itemized' === get_option('woocommerce_tax_total_display')): ?>
						<?php foreach (WC()->cart->get_tax_totals() as $code => $tax): ?>
							<div class="cart-totals__row cart-totals__row--tax">
								<span><?php echo esc_html($tax->label); ?></span>
								<span><?php echo wp_kses_post($tax->formatted_amount); ?></span>
							</div>
						<?php endforeach; ?>
					<?php else: ?>
						<div class="cart-totals__row cart-totals__row--tax">
							<span><?php echo esc_html(WC()->countries->tax_or_vat()); ?></span>
							<span><?php echo wc_cart_totals_taxes_total_html(); ?></span>
						</div>
					<?php endif; ?>
				<?php endif; ?>

				<div class="cart-totals__row cart-totals__row--total">
					<h3 class="cart-totals__total-title">Итого</h3>
					<span data-cart-total><?php wc_cart_totals_order_total_html(); ?></span>
				</div>

				<div class="cart-totals__buttons">
					<?php if (WC()->cart->get_cart_contents_count() > 0): ?>
						<a href="<?php echo esc_url(wc_get_checkout_url()); ?>"
							class="cart-totals__btn cart-totals__btn--checkout btn btn--accent">
							Перейти к оформлению
						</a>
					<?php endif; ?>
					<?php if (!empty($btn)): ?>
						<a class="cart-totals__btn cart-totals__btn--secondary btn" href="<?php echo esc_url($btn['url']); ?>">
							<?php echo esc_html($btn['title']) ?>
						</a>
					<?php endif; ?>
				</div>
				<?php if (!empty($note)): ?>
					<p class="cart-totals__note">
						<?php echo esc_html($note); ?>
					</p>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
<script>
	document.addEventListener('DOMContentLoaded', function () {
		console.log('Cart script loaded');
		if(typeof wc_cart_params === 'undefined') {
			console.error('wc_cart_params not defined');
			return;
		}
		var ajaxUrl = wc_cart_params.ajax_url;
	
			function showNotice(message, type) {
			var notice = document.createElement('div');
			notice.className = 'cart-notice cart-notice--' + type;
			notice.textContent = message;
			var cart = document.querySelector('.cart');
			if(cart) {
				cart.insertBefore(notice, cart.firstChild);
			}
			setTimeout(function () {
				notice.classList.add('cart-notice--fade-out');
					setTimeout(function () {
					notice.remove();
				}, 300);
			}, 3000);
		}

		function updateFragments(fragments) {
			if(fragments) {
				Object.keys(fragments).forEach(function (selector) {
					var element = document.querySelector(selector);
					if(element) {
						element.outerHTML = fragments[selector];
					}
				});
			}
		}
	
			function updatePricesInDOM(data) {
			var countEl = document.querySelector('[data-cart-count]');
				if(countEl) {
				countEl.textContent = data.cart_count;
			}
			var subtotalEl = document.querySelector('[data-cart-subtotal]');
			if (subtotalEl) {
				subtotalEl.innerHTML = data.cart_subtotal;
			}
			var totalEl = document.querySelector('[data-cart-total]');
			if (totalEl) {
				totalEl.innerHTML = data.cart_total;
			}
		}

		function animateCartUpdate(cartItemKey) {
			var item = document.querySelector('[data-cart-item-key="' + cartItemKey + '"]');
			if(item) {
				item.classList.add('cart-item--updating');
				setTimeout(function () {
					item.classList.remove('cart-item--updating');
				}, 600);
			}
		}
	
		function animatePriceChange(cartItemKey) {
			var item = document.querySelector('[data-cart-item-key="' + cartItemKey + '"]');
			if (item) {
				var price = item.querySelector('.cart-item__price');
				if (price) {
					price.classList.add('cart-item__price--changed');
					setTimeout(function () {
						price.classList.remove('cart-item__price--changed');
					}, 800);
				}
			}
		}
	
		function animateQuantityPulse(input) {
			var wrapper = input.closest('.quantity-input');
			if (wrapper) {
				wrapper.classList.add('quantity-input--pulse');
				setTimeout(function () {
					wrapper.classList.remove('quantity-input--pulse');
				}, 300);
			}
		}

		function animateError(cartItemKey) {
			var item = document.querySelector('[data-cart-item-key="' + cartItemKey + '"]');
			if (item) {
				item.classList.add('cart-item--error');
					setTimeout(function () {
					item.classList.remove('cart-item--error');
				}, 400);
			}
		}
	
		function animateTotalsChange() {
			var rows = document.querySelectorAll('.cart-totals__row');
				rows.forEach(function (row) {
				row.classList.add('cart-totals__row--changed');
				setTimeout(function () {
					row.classList.remove('cart-totals__row--changed');
				}, 800);
			});
		}

		function updateQuantity(button, change) {
			var wrapper = button.closest('.quantity-input');
			if (!wrapper) return;
			var input = wrapper.querySelector('.quantity-input__field');
			if (!input) return;

			var currentValue = parseInt(input.value) || 0;
			var minValue = parseInt(input.getAttribute('min')) || 0;
			var maxValue = parseInt(input.getAttribute('max'));
			var newValue = currentValue + change;
	
				if(newValue < minValue) {
				newValue = minValue;
			}
			if(!isNaN(maxValue) && maxValue > 0 && newValue > maxValue) {
				newValue = maxValue;
			}
				if(newValue === currentValue) {
				return;
			}

			input.value = newValue;
			animateQuantityPulse(input);

			var cartItemKey = input.getAttribute('data-cart-item-key');

			if (newValue === 0) {
				removeItem(cartItemKey);
				return;
			}

			var formData = new FormData();
			formData.append('cart[' + cartItemKey + '][qty]', newValue);
			formData.append('woocommerce-cart-nonce', document.querySelector('[name="woocommerce-cart-nonce"]').value);
			formData.append('action', 'woocommerce_update_cart');

			var cartItems = document.querySelector('.cart__items');
			if (cartItems) {
				cartItems.classList.add('cart__items--loading');
			}

			fetch(ajaxUrl, {
				method: 'POST',
				body: formData,
				credentials: 'same-origin'
			})
				.then(function (response) {
					return response.json();
				})
				.then(function (data) {
						if(data.fragments) {
						updateFragments(data.fragments);
						showNotice('Корзина обновлена', 'success');
					} else if (data.success && data.data) {
						updatePricesInDOM(data.data);
						animateCartUpdate(cartItemKey);
						animatePriceChange(cartItemKey);
						animateTotalsChange();
						showNotice('Корзина обновлена', 'success');
					} else {
						animateError(cartItemKey);
						showNotice('Ошибка обновления', 'error');
					}
				})
				.catch(function (error) {
					console.error('Error:', error);
					animateError(cartItemKey);
					showNotice('Ошибка соединения', 'error');
				})
				.finally(function () {
					if(cartItems) {
						cartItems.classList.remove('cart__items--loading');
					}
				});
		}

		function removeItem(cartItemKey) {
			var cartItems = document.querySelector('.cart__items');
			if (cartItems) {
				cartItems.classList.add('cart__items--loading');
			}

			var formData = new FormData();
			formData.append('cart_item_key', cartItemKey);
	
			fetch(wc_cart_params.wc_ajax_url.replace('%%endpoint%%', 'remove_from_cart'), {
				method: 'POST',
				body: formData,
				credentials: 'same-origin'
			})
				.then(function (response) {
					return response.json();
				})
				.then(function (data) {
					if(data.fragments) {
						var item = document.querySelector('[data-cart-item-key="' + cartItemKey + '"]');
							if(item) {
							item.classList.add('cart-item--removing');
						}
	
						setTimeout(function () {
							updateFragments(data.fragments);
							animateTotalsChange();
								if(item) {
								item.remove();
							}
							if (document.querySelectorAll('.cart-item').length === 0) {
								window.location.reload();
							}
						}, 400);

						showNotice('Товар удалён', 'success');
					} else {
						showNotice('Ошибка удаления', 'error');
					}
				})
				.catch(function (error) {
					console.error('Error:', error);
					showNotice('Ошибка соединения', 'error');
				})
				.finally(function () {
					if(cartItems) {
						cartItems.classList.remove('cart__items--loading');
					}
				});
		}

		document.addEventListener('click', function (e) {
			var minusBtn = e.target.closest('.quantity-input__btn--minus');
			if (minusBtn) {
				e.preventDefault();
				e.stopPropagation();
				updateQuantity(minusBtn, -1);
				return;
			}

			var plusBtn = e.target.closest('.quantity-input__btn--plus');
			if (plusBtn) {
				e.preventDefault();
				e.stopPropagation();
				updateQuantity(plusBtn, 1);
				return;
			}

			var removeBtn = e.target.closest('.cart-item__remove-btn');
			if(removeBtn) {
				e.preventDefault();
				e.stopPropagation();
				if(confirm('Удалить этот товар?')) {
					var cartItemKey = removeBtn.getAttribute('data-cart-item-key');
					removeItem(cartItemKey);
				}
				return;
			}
		});

		var changeTimeout;
		document.addEventListener('change', function (e) {
			if(e.target.classList.contains('quantity-input__field')) {
				clearTimeout(changeTimeout);
				changeTimeout = setTimeout(function () {
					var input = e.target;
					var newValue = parseInt(input.value) || 0;
					var cartItemKey = input.getAttribute('data-cart-item-key');
	
					if(newValue <= 0) {
						removeItem(cartItemKey);
						return;
					}

					var formData = new FormData();
					formData.append('cart[' + cartItemKey + '][qty]', newValue);
					formData.append('woocommerce-cart-nonce', document.querySelector('[name="woocommerce-cart-nonce"]').value);
					formData.append('action', 'woocommerce_update_cart');

					var cartItems = document.querySelector('.cart__items');
					if(cartItems) {
						cartItems.classList.add('cart__items--loading');
					}
	
					fetch(ajaxUrl, {
						method: 'POST',
						body: formData,
						credentials: 'same-origin'
					})
						.then(function (response) {
							return response.json();
						})
						.then(function (data) {
							if(data.fragments) {
								updateFragments(data.fragments);
								showNotice('Корзина обновлена', 'success');
							}	else if (data.success && data.data) {
								updatePricesInDOM(data.data);
								animateCartUpdate(cartItemKey);
								animatePriceChange(cartItemKey);
								animateTotalsChange();
								showNotice('Корзина обновлена', 'success');
							}
						})
						.catch(function (error) {
							console.error('Error:', error);
							animateError(cartItemKey);
						})
						.finally(function () {
							if (cartItems) {
								cartItems.classList.remove('cart__items--loading');
							}
						});
				}, 800);
			}
		});
	});
</script>