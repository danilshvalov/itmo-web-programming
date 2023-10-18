#include "website_list_model.hpp"

WebsiteListModel::WebsiteListModel(QObject* parent) : TableListModel(parent) {}

QVariant WebsiteListModel::columnValue(
    const WebsiteDisplayInfo& value, int column
) const {
    if (column == 0) {
        return value.url.toString();
    } else if (column == 1) {
        return QString("%1с").arg(value.show_time / 1000);
    } else {
        return QVariant();
    }
}
