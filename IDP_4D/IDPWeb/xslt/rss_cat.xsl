<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:import href="entry_cat.xsl"></xsl:import>
    <xsl:output method="xml"></xsl:output>
    <xsl:param name="shortRef" select="'Giles_1957'"></xsl:param>
    <xsl:template match="teiHeader"></xsl:template>
    <xsl:template match="text">
        <rss version="2.0">
            <channel>
                <xsl:apply-templates></xsl:apply-templates>
            </channel>
        </rss>
    </xsl:template>
    <xsl:template match="head">
        <title>
            <xsl:value-of select="$shortRef"></xsl:value-of>
        </title>
        <description>
            <xsl:for-each select="p">
                <xsl:value-of select="."></xsl:value-of>
                <br></br>
            </xsl:for-each>
        </description>
        <link>/database/oo_cat.a4d?shortref=<xsl:value-of select="$shortRef"></xsl:value-of>
        </link>
    </xsl:template>
    <xsl:template match="msDescription">
        <item>
            <title>
                <xsl:value-of select="msIdentifier/idno"></xsl:value-of>
            </title>
            <description>
                <xsl:apply-imports></xsl:apply-imports>
            </description>
            <link>/database/oo_cat.a4d?shortref=<xsl:value-of select="$shortRef"></xsl:value-of>&amp;catno=<xsl:value-of select="@n"></xsl:value-of>
            </link>
        </item>
    </xsl:template>
</xsl:stylesheet>
