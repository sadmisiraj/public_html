<div class="ccb-condition-content ccb-custom-scrollbar large" style="overflow: scroll">
	<flow-chart v-if="open" @update="change" :scene.sync="scene" @linkEdit="linkEdit" :height="height"/>
</div>
<div class="ccb-conditions-elements-wrapper" :style="{transform: collapse ? 'translateX(100%)' : ''}">
	<div class="ccb-condition-toggle" @click="collapseCondition">
		<i class="ccb-icon-Path-3398" :style="{transform: collapse ? 'rotate(0)' : ''}"></i>
	</div>
	<div class="ccb-condition-elements ccb-custom-scrollbar">
		<div class="ccb-sidebar-header">
			<span class="ccb-default-title large ccb-bold" v-if="getElements.length"><?php esc_html_e( 'Add elements', 'cost-calculator-builder-pro' ); ?></span>
			<span class="ccb-condition-elements-empty" v-else>
				<span class="ccb-default-title large ccb-bold" style="color: #878787"><?php esc_html_e( 'No elements currently available', 'cost-calculator-builder-pro' ); ?></span>
			</span>
		</div>
		<div class="ccb-conditions-items">
			<template v-for="( field, index ) in getElements">
				<div class="ccb-conditions-item" @click.prevent="if (!field.alias.includes('page')) newNode(field)">
					<span class="ccb-conditions-item-icon">
						<i :class="field.icon"></i>
					</span>
					<span class="ccb-conditions-item-box">
						<span class="ccb-default-title ccb-bold ccb-options-tooltip" v-if="field.label && field.label.length">
							<span class="ccb-options-tooltip__text" v-if="field.label.length >= 20">
								{{ field.label }}
							</span>
							<span class="ccb-default-title-short">{{ field.label | to-short }}</span>
						</span>
						<span class="ccb-default-description ccb-options-tooltip">
							<span class="ccb-options-tooltip__text" v-if="fieldLength(field.alias) >= 20">
								{{ field.alias | to-format }}
							</span>
							<span class="ccb-default-description-short">{{field.alias | to-format | to-short}}</span>
						</span>
					</span>
					<span class="ccb-icon-Path-3493 ccb-conditions-item-add" v-if="!field.alias.includes('page')" @click.prevent="if (!field.alias.includes('page')) newNode(field)"></span>
				</div>
				<div class="ccb-conditions-inner-elements" v-if="field.groupElements" v-for="inner in field.groupElements">
					<div class="ccb-conditions-inner-elements-icon">
						<i class="ccb-icon-inner-line"></i>
					</div>
					<div class="ccb-conditions-item" @click.prevent="if (field.alias.includes('page') || field.alias.includes('group')) newNode(inner)">
						<span class="ccb-conditions-item-icon">
							<i :class="inner.icon"></i>
						</span>
						<span class="ccb-conditions-item-box">
							<span class="ccb-default-title ccb-bold ccb-options-tooltip" v-if="inner.label && inner.label.length">
								<span class="ccb-options-tooltip__text" v-if="inner.label.length >= 20">
									{{ inner.label }}
								</span>
								<span class="ccb-default-title-short">{{inner.label | to-short}}</span>
							</span>
							<span class="ccb-default-description ccb-options-tooltip">
								<span class="ccb-options-tooltip__text" v-if="fieldLength(inner.alias) >= 20">
									{{ inner.alias | to-format }}
								</span>
								<span class="ccb-default-description-short">{{inner.alias | to-format | to-short}}</span>
							</span>
						</span>
						<span class="ccb-icon-Path-3493 ccb-conditions-item-add" v-if="field.alias.includes('page') || field.alias.includes('group')" @click.prevent="if (field.alias.includes('page')) newNode(inner)"></span>
					</div>
				</div>
				<template v-if="field.alias.includes('page')" v-for="groupEl in field.groupElements">
					<template v-if="groupEl.groupElements" v-for="childInGroup in groupEl.groupElements">
						<div class="ccb-conditions-inner-elements"  >
							<div class="ccb-conditions-inner-elements-icon" style="margin-left: 14px">
								<i class="ccb-icon-inner-line"></i>
							</div>
							<div class="ccb-conditions-item" @click.prevent="if (field.alias.includes('page') || field.alias.includes('group')) newNode(childInGroup)">
								<span class="ccb-conditions-item-icon">
									<i :class="childInGroup.icon"></i>
								</span>
								<span class="ccb-conditions-item-box">
									<span class="ccb-default-title ccb-bold ccb-options-tooltip" v-if="childInGroup.label && childInGroup.label.length">
										<span class="ccb-options-tooltip__text" v-if="childInGroup.label.length >= 20">
											{{ childInGroup.label }}
										</span>
										<span class="ccb-default-title-short">{{childInGroup.label | to-short}}</span>
									</span>
									<span class="ccb-default-description ccb-options-tooltip">
										<span class="ccb-options-tooltip__text" v-if="fieldLength(childInGroup.alias) >= 20">
											{{ childInGroup.alias | to-format }}
										</span>
										<span class="ccb-default-description-short">{{childInGroup.alias | to-format | to-short}}</span>
									</span>
								</span>
								<span class="ccb-icon-Path-3493 ccb-conditions-item-add" v-if="field.alias.includes('page') || field.alias.includes('group')" @click.prevent="if (field.alias.includes('page')) newNode(childInGroup)"></span>
							</div>
						</div>
					</template>
				</template>
			</template>
			<div class="ccb-sidebar-item-empty"></div>
		</div>
	</div>
</div>
