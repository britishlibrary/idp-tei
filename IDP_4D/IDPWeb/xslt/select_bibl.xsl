<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:import href="bibl.xsl"/>
    <xsl:output method="html"/>
    <xsl:param name="shortRef" select="'Karmay_1988'"/>
    <xsl:template match="bibl">
        <xsl:choose>
            <xsl:when test="@id=$shortRef">
                <xsl:apply-imports/>
            </xsl:when>
            <xsl:otherwise> </xsl:otherwise>
        </xsl:choose>
    </xsl:template>
</xsl:stylesheet>
