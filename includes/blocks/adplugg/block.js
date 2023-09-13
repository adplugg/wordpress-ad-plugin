/**
 * The AdPlugg Gutenberg block.
 *
 * @package AdPlugg
 * @since 1.11.0
 */
(
    function( blocks, components, element, blockEditor ) {
        var el = element.createElement;
        var InspectorControls = blockEditor.InspectorControls;
        var PanelBody = components.PanelBody;
        var TextControl = components.TextControl;
        var useBlockProps = blockEditor.useBlockProps;

        /**
         * Icon for the AdPlugg block in the block menu (Mr. Pickles).
        */
        var iconEl = el( 'svg', { width: 20, height: 20, viewBox: "0 0 673.57 663.79" },
            el( 'path', { d: 'm669.8 143.64c-60.72-41.34-56.33-101.77-83.46-105.73-24.5-3.58-48 14.22-60 25.3-29.09-14-64.77-23.53-105.57-28-39.1-4.29-75.19-3.1-106.5 3.42-9.17-13.5-28.27-36.48-53.13-38.57-27.32-2.29-36.14 57.62-104.41 84.14-15.41 6 5.43 30.14 41.13 34.72-7.29 9.56-12.21 20.41-13.4 31.69-1.66 15.83 3.29 31.93 12.31 45.6a184.06 184.06 0 0 0 6.67 32.72c-32.18 7.41-64.49 17.37-91 32.59-7.07-2.89-13.88-6-18.36-8.81-11.61-7.32-22.84-19.17-23-34-.19-28.04 39.61-40.92 47.92-10.71 2.73 9.9 4.57 25.24 18.43 13.6 9.76-8.19 13.74-21.89 10.61-34.29-13.15-52.18-89.12-53.37-116.94-16.77-32.1 42.24-10.3 106 42.57 123-18.12 22-27.34 49.26-30.12 82.19-1.88 22.18-1.38 46.7-11.52 67-5.13 10.29-13.41 17.51-19.94 26.7-7.14 10-8.46 23.35-9.94 35.29-2.86 23.06-3.61 48.47 2.55 71.06 5.81 21.3 23 29.9 43.47 32.78 15.84 2.23 38.71-2.39 41.55-21.82 1.16-7.93-1.69-16.1-6.49-22.29a31.45 31.45 0 0 0 -9-8 100.4 100.4 0 0 1 -3.39-21.24c-.67-9.17-.88-18.83 2.26-27.57a268.44 268.44 0 0 0 27.86-8.06c.67-.23 1.34-.48 2-.73 3.73 19.58 9.49 39.77 20.13 54.92 10.49 15 32.77 16.89 49.34 14.3s30.13-16.25 17.88-33.23c-3.93-5.45-15-8.68-17.43-13.64-3.85-10.45-6.88-21.8-6.18-33.06.71-2.62 12.85-10.33 16.74-13.83a118 118 0 0 0 13-13.83c15.1 6.72 33.53 14.78 49.16 21.13-.16 9 .07 16.26.24 18.36a305.15 305.15 0 0 0 20.54 87.77c9.48 23.73 21.25 54.67 43.8 68.47 18.07 11.07 54.65 12.08 64.81-11.4 8.6-19.86-15.53-40.82-30.62-48.47-6.56-27.25-6.92-57-3.9-84.74.33-3 .6-5.7.86-8.22a174.43 174.43 0 0 0 73.38-13.92 242.35 242.35 0 0 0 25.47-12.59q.81 4 1.55 8a256.74 256.74 0 0 1 4.39 39.78c.33 13.49-3.28 26.38-3.47 39.78-.86 61.63 113.21 32.66 62.51-16.73-10.47-10.2-1.4-37.41 1-49.45 5.58-28.37 12-56.82 13.47-85.81a280.68 280.68 0 0 0 .06-29.4c3.15-14.26 3.63-29.17 2.45-44.08 42.86-21.44 66.86-58.11 78.86-98.61 11.52-11.09 19.63-25.45 21.26-41 1.13-10.65-1.2-21.66-5.93-32 38.75 6.49 67.93-13.87 53.47-23.71zm-595.11 414.46c-.31-.9-.06-.19 0 0z' } )
        );

        blocks.registerBlockType(
            'adplugg/adplugg',
            {
                icon: iconEl,
                edit: function( props ) {
                    var zone = props.attributes.zone;

                    function onChangeZone( newZone ) {
                        props.setAttributes( {
                            zone: ( ( undefined === newZone  ) ? null : newZone )
                        } );
                    }

                    return [
                        el(
                            InspectorControls,
                            null,
                            el(
                                PanelBody,
                                {
                                    title: "Basic Settings",
                                    initialOpen: true
                                },
                                el(
                                    TextControl,
                                    {
                                        label: "Zone",
                                        value: zone,
                                        onChange: onChangeZone
                                    }
                                ),
                            )
                        ),
                        el(
                            'p',
                            useBlockProps( { className: props.className } ),
                            ( props.attributes.zone !== undefined ? 'AdPlugg: ' + props.attributes.zone : 'AdPlugg' )
                        )
                    ];

                },
                save: function( props ) {
                    return el(
                        'div',
                        useBlockProps.save(
                            {
                                className: "adplugg-tag",
                                "data-adplugg-zone": ( props.attributes.zone !== 'undefined' ? props.attributes.zone : null )
                            }
                        )
                    );
                }
            }
        );

    }( window.wp.blocks, window.wp.components, window.wp.element, window.wp.blockEditor )
);
