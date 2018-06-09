<?php

/**
 * Class MW_EXT_Color
 * ------------------------------------------------------------------------------------------------------------------ */

class MW_EXT_Color {

	/**
	 * Clear DATA (escape html).
	 *
	 * @param $string
	 *
	 * @return string
	 * -------------------------------------------------------------------------------------------------------------- */

	private static function clearData( $string ) {
		$outString = htmlspecialchars( trim( $string ), ENT_QUOTES );

		return $outString;
	}

	/**
	 * Register tag function.
	 *
	 * @param Parser $parser
	 *
	 * @return bool
	 * @throws MWException
	 * -------------------------------------------------------------------------------------------------------------- */

	public static function onParserFirstCallInit( Parser $parser ) {
		$parser->setHook( 'color', __CLASS__ . '::onRenderTag' );

		return true;
	}

	/**
	 * Render tag function.
	 *
	 * @param $input
	 * @param array $args
	 * @param Parser $parser
	 * @param PPFrame $frame
	 *
	 * @return string
	 * -------------------------------------------------------------------------------------------------------------- */

	public static function onRenderTag( $input, $args = [], Parser $parser, PPFrame $frame ) {
		// Argument: type.
		$getType = self::clearData( $args['type'] ?? '' ?: '' );
		$outType = empty( $getType ) ? '' : ' style="color:' . $getType . ';"';

		// Get content.
		$getContent = trim( $input );
		$outContent = $parser->recursiveTagParse( $getContent, $frame );

		// Out HTML.
		$outHTML = '<span' . $outType . ' class="mw-ext-color">' . $outContent . '</span>';

		// Out parser.
		$outParser = $outHTML;

		return $outParser;
	}

	/**
	 * Load resource function.
	 *
	 * @param OutputPage $out
	 * @param Skin $skin
	 *
	 * @return bool
	 * -------------------------------------------------------------------------------------------------------------- */

	public static function onBeforePageDisplay( OutputPage $out, Skin $skin ) {
		$out->addModuleStyles( array( 'ext.mw.color.styles' ) );

		return true;
	}
}
