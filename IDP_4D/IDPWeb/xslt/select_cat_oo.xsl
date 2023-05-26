<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:import href="entry_cat.xsl"/>
    <xsl:output method="html"/>
    <xsl:param name="catNumber" select="'10'"/>
    <xsl:param name="shortRef" select="'Thilo_1985'"/>
    <xsl:template match="teiHeader"/>
    <xsl:template match="head"/>
    <xsl:template match="msDescription">
        <xsl:choose>
            <xsl:when test="attribute::n=$catNumber">
                <xsl:apply-imports/>
            </xsl:when>
            <xsl:otherwise> </xsl:otherwise>
        </xsl:choose>
    </xsl:template>
</xsl:stylesheet>
