#pragma once

#include "table_list_model.hpp"
#include "website_display_info.hpp"

class WebsiteListModel : public TableListModel<WebsiteDisplayInfo> {
   public:
    WebsiteListModel(QObject* parent = nullptr);

   protected:
    QVariant columnValue(
        const WebsiteDisplayInfo& value,  //
        int column
    ) const override;
};
