<div class="cbb-edit-field-container">
	<div class="ccb-edit-field-header">
		<span class="ccb-edit-field-title ccb-heading-3 ccb-bold"><?php esc_html_e( 'Geolocation Field', 'cost-calculator-builder-pro' ); ?></span>
		<div class="ccb-field-actions">
			<button class="ccb-button default" @click.prevent="$emit( 'cancel' )"><?php esc_html_e( 'Cancel', 'cost-calculator-builder-pro' ); ?></button>
			<button class="ccb-button success" @click.prevent="save"><?php esc_html_e( 'Save', 'cost-calculator-builder-pro' ); ?></button>
		</div>
	</div>
	<div class="ccb-grid-box">
		<div class="row">
			<div class="col-12">
				<div class="ccb-edit-field-switch">
					<div class="ccb-edit-field-switch-item ccb-default-title" :class="{active: tab === 'main'}" @click="tab = 'main'">
						<?php esc_html_e( 'Element', 'cost-calculator-builder-pro' ); ?>
						<span class="ccb-fields-required" v-if="errorsCount > 0">{{ errorsCount }}</span>
					</div>
					<div class="ccb-edit-field-switch-item ccb-default-title" :class="{active: tab === 'settings'}" @click="tab = 'settings'">
						<?php esc_html_e( 'Settings', 'cost-calculator-builder-pro' ); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="row ccb-p-t-15" v-if="!checkGoogleMapApi">
			<div class="col-12">
				<div class="ccb-location-notice">
					<div class="ccb-location-notice__icon">
						<i class="ccb-icon-Path-3367"></i>
					</div>
					<div class="ccb-location-notice__text">
						<div class="ccb-location-notice__description">
							<?php esc_html_e( 'You haven’t set up map integration in the settings.', 'cost-calculator-builder-pro' ); ?>
						</div>
						<div class="ccb-location-notice__link">
							<a href="<?php echo esc_url( get_admin_url() . 'admin.php?page=cost_calculator_builder&tab=settings' ); ?>"><?php esc_html_e( 'Go to the calculator settings and add API keys.', 'cost-calculator-builder-pro' ); ?></a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container"  v-show="tab === 'main'" v-if="checkGoogleMapApi">
			<div class="row ccb-p-t-15">
				<div class="col-12">
					<div class="ccb-input-wrapper">
						<span class="ccb-input-label"><?php esc_html_e( 'Name', 'cost-calculator-builder-pro' ); ?></span>
						<input type="text" class="ccb-heading-5 ccb-light" v-model.trim="geolocationField.label" placeholder="<?php esc_attr_e( 'Enter field name', 'cost-calculator-builder-pro' ); ?>">
					</div>
				</div>
			</div>
			<div class="row ccb-p-t-20">
				<div class="col-12">
					<div class="ccb-input-wrapper">
						<span class="ccb-input-label"><?php esc_html_e( 'What do you want to use geolocation for?', 'cost-calculator-builder-pro' ); ?></span>
					</div>
				</div>
			</div>
			<div class="row ccb-p-t-15">
				<div class="col-12">
					<div class="ccb-radio-wrapper">
						<input type="radio" id="userLocation" v-model="geolocationField.geoType" value="userLocation">
						<label for="userLocation"><?php esc_html_e( 'Request user’s location', 'cost-calculator-builder-pro' ); ?></label>
						<span class="description"><?php esc_html_e( 'Let users calculate the distance from their location to your place', 'cost-calculator-builder-pro' ); ?></span>
					</div>
				</div>
				<div class="col-12 ccb-p-t-20">
					<div class="ccb-radio-wrapper">
						<input type="radio" id="twoPointLocation" v-model="geolocationField.geoType" value="twoPointLocation">
						<label for="twoPointLocation"><?php esc_html_e( 'Ask users to choose starting and destination points', 'cost-calculator-builder-pro' ); ?></label>
						<span class="description"><?php esc_html_e( 'Let users calculate the distance between two points on the map', 'cost-calculator-builder-pro' ); ?></span>
					</div>
				</div>
				<div class="col-12 ccb-p-t-20 ccb-p-b-10">
					<div class="ccb-radio-wrapper">
						<input type="radio" id="multiplyLocation" v-model="geolocationField.geoType" value="multiplyLocation">
						<label for="multiplyLocation"><?php esc_html_e( 'Ask to choose one among multiple locations', 'cost-calculator-builder-pro' ); ?></label>
						<span class="description"><?php esc_html_e( 'Let users calculate the distance between multiple locations and select one', 'cost-calculator-builder-pro' ); ?></span>
					</div>
				</div>
				<div class="border-bottom" style="height: 1px; width: 94%; margin: 10px auto;"></div>
			</div>
			<div class="row ccb-p-t-15" v-show="geolocationField.geoType === 'userLocation'">
				<div class="col-12">
					<div class="list-header">
						<div class="ccb-switch">
							<input type="checkbox" v-model="geolocationField.costDistance"/>
							<label></label>
						</div>
						<h6 class="ccb-heading-5"><?php esc_html_e( 'Calculate cost of distance', 'cost-calculator-builder-pro' ); ?></h6>
					</div>
				</div>
				<div class="col-12 ccb-p-t-15" v-show="geolocationField.costDistance">
					<div class="row vertical-center">
						<div class="col-7">
							<div class="ccb-input-wrapper">
								<span class="ccb-input-label" :class="{'error': userLocationError && !geolocationField.userLocation}"><?php esc_html_e( 'Add your location', 'cost-calculator-builder-pro' ); ?></span>
							</div>
						</div>
						<div class="col-12" v-show="!geolocationField.userLocation">
							<button class="ccb-button light" style="height: 100%; padding: 11px 16px;" @click="showLocationPopup('userLocation')">
								<?php esc_html_e( 'Select location', 'cost-calculator-builder-pro' ); ?>
							</button>
						</div>
						<div class="col-12 ccb-p-t-15" v-if="userLocationError && !geolocationField.userLocation">
							<div class="ccb-notice ccb-error">
								<span class="ccb-notice-title"><?php esc_html_e( 'Error! ', 'cost-calculator-builder-pro' ); ?></span>
								<span class="ccn-notice-description"><?php esc_html_e( 'Please select a location to proceed.', 'cost-calculator-builder-pro' ); ?></span>
							</div>
						</div>
						<div class="col-7" v-show="geolocationField.userLocation">
							<div class="location-info">
								<span class="coordinate">{{ geolocationField.userLocation }}</span>
								<span class="address">{{ geolocationField.userAddress }}</span>
								<button class="ccb-button light edit" style="height: 100%; padding: 11px 16px;" @click="showLocationPopup('userLocation', geolocationField.userLocation)">
									<?php esc_html_e( 'Edit location', 'cost-calculator-builder-pro' ); ?>
								</button>
							</div>
						</div>
						<div class="col-5" v-show="geolocationField.userLocation">
							<div class="location-info-map">
								<div id="userLocationMap" class="map" style="width: 100%; height: 100%;"></div>
							</div>
						</div>
					</div>
					<div class="row ccb-p-t-15">
						<div class="col-6">
							<div class="ccb-select-box">
								<span class="ccb-select-label"><?php esc_html_e( 'How to calculate the cost?', 'cost-calculator-builder-pro' ); ?></span>
								<div class="ccb-select-wrapper">
									<i class="ccb-icon-Path-3485 ccb-select-arrow"></i>
									<select class="ccb-select" v-model="geolocationField.pricingType">
										<option value="each"><?php esc_html_e( 'Fixed cost per', 'cost-calculator-builder-pro' ); ?> {{ measure }}</option>
										<option value="fixed"><?php esc_html_e( 'Ranged price for the distance', 'cost-calculator-builder-pro' ); ?></option>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="row ccb-p-t-15" v-if="geolocationField.pricingType === 'each'">
						<div class="col-4">
							<div class="ccb-input-wrapper">
								<span class="ccb-input-label"><?php esc_html_e( 'Cost', 'cost-calculator-builder-pro' ); ?></span>
								<div class="ccb-input-box">
									<input type="number" class="ccb-heading-5 ccb-light" name="eachCost" v-model="geolocationField.eachCost" placeholder="<?php esc_attr_e( 'Enter value', 'cost-calculator-builder-pro' ); ?>">
									<span @click="numberCounterAction('eachCost')" class="input-number-counter up"></span>
									<span @click="numberCounterAction('eachCost', '-')" class="input-number-counter down"></span>
								</div>
							</div>
						</div>
						<div class="col-8" style="margin-top: 35px; margin-left: -15px;">
							<div class="ccb-input-info">
								<span class="title">{{ currency }}<?php esc_html_e( '/per ', 'cost-calculator-builder-pro' ); ?> {{ measure }}</span>
								<span class="ccb-options-tooltip">
									<i class="ccb-icon-circle-question"></i>
									<span class="ccb-options-tooltip__text"><?php esc_html_e( 'Measuring unit can be changed from the settings tab', 'cost-calculator-builder-pro' ); ?></span>
								</span>
							</div>
						</div>
					</div>
					<div class="row ccb-p-t-15" v-if="geolocationField.pricingType === 'fixed'">
						<div class="col-12">
							<div class="row ccb-distance-range-header">
								<div class="col-6">
									<div class="ccb-distance-range-header__title" style="margin-left: -12px"><?php esc_html_e( 'Distance range', 'cost-calculator-builder-pro' ); ?></div>
								</div>
								<div class="col-6">
									<div class="ccb-distance-range-header__title"><?php esc_html_e( 'Range cost', 'cost-calculator-builder-pro' ); ?></div>
								</div>
							</div>	
						</div>
						<div class="col-12">
							<div class="ccb-distance-row" v-for="( distanceCost, index ) in distanceCostOptions" :key="index">
								<div class="row">
									<div class="col-6" style="display: flex; gap: 10px;">
										<div class="ccb-distance-range-from">
											from {{  distanceCost.from }} to
										</div>
										<div class="ccb-input-wrapper" style="max-width: 70px;">
											<div class="ccb-input-box">
												<input type="number" class="ccb-heading-5 ccb-light" name="to" v-model="distanceCost.to" placeholder="<?php esc_attr_e( 'Enter value', 'cost-calculator-builder-pro' ); ?>">
												<span @click="costCounterAction('to', '+', index)" class="input-number-counter up"></span>
												<span @click="costCounterAction('to', '-', index)" class="input-number-counter down"></span>
											</div>
										</div>
										<div class="ccb-distance-range-info">
											<span class="title">{{ measure }}:</span>
										</div>
									</div>
									<div class="col-6" style="display:flex; gap: 6px;">
										<div class="ccb-input-wrapper" style="max-width: 130px;">
											<div class="ccb-input-box">
												<input type="number" class="ccb-heading-5 ccb-light" name="cost" v-model="distanceCost.cost" placeholder="<?php esc_attr_e( 'Enter value', 'cost-calculator-builder-pro' ); ?>">
												<span @click="costCounterAction('cost', '+', index)" class="input-number-counter up"></span>
												<span @click="costCounterAction('cost', '-', index)" class="input-number-counter down"></span>
											</div>
										</div>
										<div class="ccb-distance-range-info">
											<span class="title">{{ currency }}</span>
										</div>
										<div class="ccb-distance-range-delete" @click="deleteCostRow(index)"  v-if="index != 0 && index == Object.keys(distanceCostOptions).length - 1">
											<i class="ccb-icon-close-x"></i>
										</div>
									</div>
								</div>
							</div>
							<div class="ccb-p-t-15 ccb-distance-row">
								<div class="row">
									<div class="col-6" style="display: flex; gap: 10px;">
										<div class="ccb-distance-range-from">
											{{ geolocationField.lastDistanceCost.from }}+ {{ measure }}:
										</div>
									</div>
									<div class="col-6" style="display:flex; gap: 6px;">
										<div class="ccb-input-wrapper" style="max-width: 130px;">
											<div class="ccb-input-box">
												<input type="number" class="ccb-heading-5 ccb-light" name="lastDistanceCost" v-model="geolocationField.lastDistanceCost.cost" placeholder="<?php esc_attr_e( 'Enter value', 'cost-calculator-builder-pro' ); ?>">
												<span @click="lastDistanceCostCounterAction('lastDistanceCost', '+')" class="input-number-counter up"></span>
												<span @click="lastDistanceCostCounterAction('lastDistanceCost', '-')" class="input-number-counter down"></span>
											</div>
										</div>
										<div class="ccb-distance-range-info">
											<span class="title">{{ currency }}</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12">
							<div class="ccb-distance-range-action">
								<button class="ccb-button" @click="addDistanceCost">
									<i class="ccb-icon-plus-lite"></i>
									<span><?php esc_html_e( 'Add another range', 'cost-calculator-builder-pro' ); ?></span>
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row ccb-p-t-15" v-if="geolocationField.geoType === 'twoPointLocation'">
				<div class="col-12">
					<div class="row">
						<div class="col-6">
							<div class="ccb-select-box">
								<span class="ccb-select-label"><?php esc_html_e( 'How to calculate the cost?', 'cost-calculator-builder-pro' ); ?></span>
								<div class="ccb-select-wrapper">
									<i class="ccb-icon-Path-3485 ccb-select-arrow"></i>
									<select class="ccb-select" v-model="geolocationField.pricingType">
										<option value="each"><?php esc_html_e( 'Fixed cost per', 'cost-calculator-builder-pro' ); ?> {{ measure }}</option>
										<option value="fixed"><?php esc_html_e( 'Ranged price for the distance', 'cost-calculator-builder-pro' ); ?></option>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="row ccb-p-t-15" v-if="geolocationField.pricingType === 'each'">
						<div class="col-4">
							<div class="ccb-input-wrapper">
								<span class="ccb-input-label"><?php esc_html_e( 'Cost', 'cost-calculator-builder-pro' ); ?></span>
								<div class="ccb-input-box">
									<input type="number" class="ccb-heading-5 ccb-light" name="eachCost" v-model="geolocationField.eachCost" placeholder="<?php esc_attr_e( 'Enter value', 'cost-calculator-builder-pro' ); ?>">
									<span @click="numberCounterAction('eachCost')" class="input-number-counter up"></span>
									<span @click="numberCounterAction('eachCost', '-')" class="input-number-counter down"></span>
								</div>
							</div>
						</div>
						<div class="col-8" style="margin-top: 35px; margin-left: -15px;">
							<div class="ccb-input-info">
								<span class="title">{{ currency }}<?php esc_html_e( '/per ', 'cost-calculator-builder-pro' ); ?> {{ measure }}</span>
								<span class="ccb-options-tooltip">
									<i class="ccb-icon-circle-question"></i>
									<span class="ccb-options-tooltip__text"><?php esc_html_e( 'Measuring unit can be changed from the settings tab', 'cost-calculator-builder-pro' ); ?></span>
								</span>
							</div>
						</div>
					</div>
					<div class="row ccb-p-t-15" v-if="geolocationField.pricingType === 'fixed'">
						<div class="col-12">
							<div class="row ccb-distance-range-header">
								<div class="col-6">
									<div class="ccb-distance-range-header__title" style="margin-left: -12px"><?php esc_html_e( 'Distance range', 'cost-calculator-builder-pro' ); ?></div>
								</div>
								<div class="col-6">
									<div class="ccb-distance-range-header__title"><?php esc_html_e( 'Range cost', 'cost-calculator-builder-pro' ); ?></div>
								</div>
							</div>	
						</div>
						<div class="col-12">
							<div class="ccb-distance-row" v-for="( distanceCost, index ) in distanceCostOptions" :key="index">
								<div class="row">
									<div class="col-6" style="display: flex; gap: 10px;">
										<div class="ccb-distance-range-from">
											from {{  distanceCost.from }} to
										</div>
										<div class="ccb-input-wrapper" style="max-width: 70px;">
											<div class="ccb-input-box">
												<input type="number" class="ccb-heading-5 ccb-light" name="to" v-model="distanceCost.to" placeholder="<?php esc_attr_e( 'Enter value', 'cost-calculator-builder-pro' ); ?>">
												<span @click="costCounterAction('to', '+', index)" class="input-number-counter up"></span>
												<span @click="costCounterAction('to', '-', index)" class="input-number-counter down"></span>
											</div>
										</div>
										<div class="ccb-distance-range-info">
											<span class="title">{{measure}}:</span>
										</div>
									</div>
									<div class="col-6" style="display:flex; gap: 6px;">
										<div class="ccb-input-wrapper" style="max-width: 130px;">
											<div class="ccb-input-box">
												<input type="number" class="ccb-heading-5 ccb-light" name="cost" v-model="distanceCost.cost" placeholder="<?php esc_attr_e( 'Enter value', 'cost-calculator-builder-pro' ); ?>">
												<span @click="costCounterAction('cost', '+', index)" class="input-number-counter up"></span>
												<span @click="costCounterAction('cost', '-', index)" class="input-number-counter down"></span>
											</div>
										</div>
										<div class="ccb-distance-range-info">
											<span class="title">{{ currency }}</span>
										</div>
										<div class="ccb-distance-range-delete" @click="deleteCostRow(index)" v-if="index != 0 && index == Object.keys(distanceCostOptions).length - 1">
											<i class="ccb-icon-close-x"></i>
										</div>
									</div>
								</div>
							</div>

							<div class="ccb-p-t-15 ccb-distance-row">
								<div class="row">
									<div class="col-6" style="display: flex; gap: 10px;">
										<div class="ccb-distance-range-from">
											{{ geolocationField.lastDistanceCost.from }}+ {{ measure }}:
										</div>
									</div>
									<div class="col-6" style="display:flex; gap: 6px;">
										<div class="ccb-input-wrapper" style="max-width: 130px;">
											<div class="ccb-input-box">
												<input type="number" class="ccb-heading-5 ccb-light" name="eachCost" v-model="geolocationField.lastDistanceCost.cost" placeholder="<?php esc_attr_e( 'Enter value', 'cost-calculator-builder-pro' ); ?>">
												<span @click="lastDistanceCostCounterAction('lastDistanceCost')" class="input-number-counter up"></span>
												<span @click="lastDistanceCostCounterAction('lastDistanceCost', '-')" class="input-number-counter down"></span>
											</div>
										</div>
										<div class="ccb-distance-range-info">
											<span class="title">{{ currency }}</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12">
							<div class="ccb-distance-range-action">
								<button class="ccb-button" @click="addDistanceCost">
									<i class="ccb-icon-plus-lite"></i>
									<span><?php esc_html_e( 'Add another range', 'cost-calculator-builder-pro' ); ?></span>
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row ccb-p-t-15" v-show="geolocationField.geoType === 'multiplyLocation'">
				<div class="col-12">
					<div class="ccb-location ccb-p-b-20" v-for="( location, index ) in multiLocationOptions" :key="index">
						<div class="location-multiply" :class="{'location-error': multiSelectError && !location.coordinates}">
							<div class="location-multiply__header">
								<i class="ccb-icon-location"></i>
								<span class="location-multiply__title"><?php esc_html_e( 'Add your location', 'cost-calculator-builder-pro' ); ?></span>
								<i class="ccb-icon-close-x close" v-if="index != 0 && index != 1" @click="removeLocation(index)"></i>
							</div>
							<div class="location-multiply__body" v-show="location.coordinates">
								<div class="location-multiply__edit">
									<div class="location-multiply__info">
										<span class="coordinate">{{ location.coordinates }}</span>
										<span class="address">{{ location.addressName }}</span>
										<button class="ccb-button light edit" style="height: 100%; padding: 11px 16px;" @click="showLocationPopup('multiplyLocations', location.coordinates, index)">
											<?php esc_html_e( 'Edit location', 'cost-calculator-builder-pro' ); ?>
										</button>
									</div>
									<div class="location-multiply__map">
										<div class="map" :id="'map-' + index" style="width: 100%; height: 100%;"></div>
									</div>
								</div>
							</div>
							<div class="location-multiply__empty" v-if="!location.coordinates">
								<button class="ccb-button light edit" style="height: 100%; padding: 11px 16px;" @click="showLocationPopup('multiplyLocations', false, index)">
									<?php esc_html_e( 'Select location', 'cost-calculator-builder-pro' ); ?>
								</button>
							</div>
							<div class="location-multiply__error ccb-p-t-15" >
								<div class="ccb-notice ccb-error">
									<span class="ccb-notice-title"><?php esc_html_e( 'Error! ', 'cost-calculator-builder-pro' ); ?></span>
									<span class="ccn-notice-description"><?php esc_html_e( 'Please select a location to proceed.', 'cost-calculator-builder-pro' ); ?></span>
								</div>
							</div>
							<div class="location-multiply__footer">
								<div class="ccb-input-wrapper">
									<input type="text" placeholder="Name of place on the map" v-model="location.label" class="ccb-heading-5 ccb-light">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-12">
					<div class="ccb-location-actions">
						<button class="ccb-button ccb-location-add" @click="addLocation">
							<i class="ccb-icon-plus-lite"></i>
							<span><?php esc_html_e( 'Add another location', 'cost-calculator-builder-pro' ); ?></span>
						</button>
					</div>
				</div>
			</div>
			<location-popup 
				:options="mapProps"
				:api="checkGoogleMapApi"
				ref="locationMap"
				@init-location="setLocation"
			/>	
		</div>
		<div class="container" v-show="tab === 'settings'" v-if="checkGoogleMapApi">
			<div class="row ccb-p-t-15">
				<div class="col-6 ccb-p-t-10">
					<div class="list-header">
						<div class="ccb-switch">
							<input type="checkbox" v-model="geolocationField.required"/>
							<label></label>
						</div>
						<h6 class="ccb-heading-5"><?php esc_html_e( 'Required', 'cost-calculator-builder-pro' ); ?></h6>
					</div>
				</div>
				<div class="col-6 ccb-p-t-10" v-if="!disableFieldHiddenByDefault(geolocationField)">
					<div class="list-header">
						<div class="ccb-switch">
							<input type="checkbox" v-model="geolocationField.hidden"/>
							<label></label>
						</div>
						<h6 class="ccb-heading-5"><?php esc_html_e( 'Hidden by Default', 'cost-calculator-builder-pro' ); ?></h6>
					</div>
				</div>
				<div class="col-6 ccb-p-t-10" v-if="!disableFieldHiddenByDefault(geolocationField)">
					<div class="list-header">
						<div class="ccb-switch">
							<input type="checkbox" v-model="geolocationField.calculateHidden"/>
							<label></label>
						</div>
						<h6 class="ccb-heading-5"><?php esc_html_e( 'Calculate hidden by default', 'cost-calculator-builder' ); ?></h6>
					</div>
				</div>
				<div class="col-6 ccb-p-t-10" v-if="geolocationField.geoType !== 'multiplyLocation'">
					<div class="list-header">
						<div class="ccb-switch">
							<input type="checkbox" v-model="geolocationField.allowCurrency"/>
							<label></label>
						</div>
						<h6 class="ccb-heading-5"><?php esc_html_e( 'Currency Sign', 'cost-calculator-builder-pro' ); ?></h6>
					</div>
				</div>
				<div class="col-6 ccb-p-t-10">
					<div class="list-header">
						<div class="ccb-switch">
							<input type="checkbox" v-model="geolocationField.addToSummary"/>
							<label></label>
						</div>
						<h6 class="ccb-heading-5"><?php esc_html_e( 'Show in Grand Total', 'cost-calculator-builder-pro' ); ?></h6>
					</div>
				</div>
			</div>
			<div class="row ccb-p-t-15">
				<div class="col-12">
					<div class="ccb-input-wrapper">
						<span class="ccb-input-label"><?php esc_html_e( 'Additional Classes', 'cost-calculator-builder-pro' ); ?></span>
						<textarea class="ccb-heading-5 ccb-light" v-model="geolocationField.additionalStyles" placeholder="<?php esc_attr_e( 'Set Additional Classes', 'cost-calculator-builder-pro' ); ?>"></textarea>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
