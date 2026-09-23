/**
 * Enlace de WhatsApp con un mensaje precargado.
 */
export function whatsappUrl(number: string, message: string): string {
    return `https://wa.me/${number}?text=${encodeURIComponent(message)}`;
}

export function serviceWhatsappMessage(phrase: string): string {
    return `Hola, me interesa ${phrase} de SPP. ¿Me pueden dar información y una cotización?`;
}
