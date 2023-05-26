<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:import href="bibl.xsl"/>
    <xsl:output method="html"/>
    <xsl:template match="TEI.2/teiHeader/fileDesc/titleStmt/title">
        <h2>
            <xsl:apply-templates/>
        </h2>
    </xsl:template>
    <xsl:template match="TEI.2/teiHeader/fileDesc/titleStmt/author">
        <xsl:apply-templates/>
        <br/>
    </xsl:template>
    <xsl:template match="TEI.2/teiHeader/fileDesc/titleStmt/editor">
        <xsl:apply-templates/><xsl:text> (ed.)</xsl:text><br/>
    </xsl:template>
    <xsl:template match="TEI.2/teiHeader/fileDesc/titleStmt/respStmt">
        <xsl:apply-templates/><xsl:text> (contributor)</xsl:text><br/>
        <xsl:choose>
            <xsl:when test="@type">
                <xsl:value-of select="."></xsl:value-of>
                <xsl:text> (</xsl:text>
                <xsl:value-of select="@type"></xsl:value-of>
                <xsl:text>)</xsl:text><br/>
            </xsl:when>
            <xsl:otherwise>
                <xsl:value-of select="."></xsl:value-of>
                <xsl:text> (contributor)</xsl:text><br/>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>
    <xsl:template match="TEI.2/teiHeader/fileDesc/publicationStmt">
        <xsl:value-of select="pubPlace"/>: <xsl:value-of select="publisher"/>, <xsl:value-of
            select="date"/>.<br/> </xsl:template>
    <xsl:template match="TEI.2/teiHeader/fileDesc/editionStmt">
        <xsl:value-of select="edition"/><br/>
    </xsl:template>
    <xsl:template match="TEI.2/teiHeader/fileDesc/revisionDesc">
                <br/><xsl:text>Revised by </xsl:text><xsl:value-of select="resp"/> (<xsl:value-of select="date"/>).
    </xsl:template>
    <xsl:template match="TEI.2/teiHeader/fileDesc/sourceDesc/bibl">
        <br/>
        Bibliographical reference:<br/>
        <xsl:apply-imports/>
        <br/>
    </xsl:template>  
    <xsl:template match="TEI.2/teiHeader/fileDesc/sourceDesc/p"></xsl:template>
    <xsl:template match="TEI.2/teiHeader/encodingDesc"></xsl:template>
    <xsl:template match="TEI.2/text"></xsl:template>
</xsl:stylesheet>
